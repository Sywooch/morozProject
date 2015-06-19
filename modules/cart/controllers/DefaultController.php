<?php

namespace app\modules\cart\controllers;

use app\models\LoginForm;
use app\models\SignupForm;
use app\modules\cart\models\CompareUser;
use yii\web\Controller;
use Yii;
use app\modules\cart\models\OrdersForm;
use app\modules\cart\models\User;
use app\modules\cart\models\Orders;
use app\modules\cart\models\OrdersGoods;
use yii\web\HttpException;
use yii\data\Pagination;
use yii\web\Session;
use yii\web\Request;

use app\modules\cart\widgets\CartWidget; 

class DefaultController extends Controller{

    public function __constract(){

    }
    public function actionIndex(){
        
        $cart_view = self::getCart();
        return $this->render('cart',  [
            'goods'=>$cart_view,
        ]);
    }


    public static function getCart(){
        $session = new Session;
        $session->open();
        $products=$session->get('products');

        $goods=array();
        // получаем перечень товаров для вывода
        if(count($products)>0){
            $goods_id_string=  implode(",",array_keys($products));
            $db = Yii::$app->db;
            $goods = $db->createCommand("SELECT goods.*,goods_images.imgname FROM goods
                                          LEFT JOIN goods_images ON goods_images.goods_id = goods.id AND goods_images.chief = 'Y'
                                          WHERE goods.id IN ($goods_id_string)")->queryAll();
            foreach ($goods as  $key=>$goods_one){
                // TODO:если есть свойства, то доработать алгоритм
                if(isset($products[$goods_one['id']]['count'])){
                    $goods[$key]['count']=$products[$goods_one['id']]['count'];
                }
            }
        }

        return $goods;
    }


    public function actionDel(){
        $session = new Session;
        $session->open();
        $products = $session->get('products');
        $goods_id = (int)Yii::$app->request->post('goods_id',1);
        unset($products[$goods_id]);
        $session->set('products',$products);
        $cart_widget = CartWidget::widget(["no_wrap"=>true]);
        echo json_encode(array("ok"=>"true","cart_widget"=>$cart_widget));
        exit;
    }



    // пересчет товаров в корзине по ajax запросу
    public function actionBay(){
        // TODO: включить проверку ajax запроса
        $session = new Session;
        $session->open();
        $goods_id=(int)Yii::$app->request->post('goods_id',1);
        $count=(int)Yii::$app->request->post('cnt',1);
        
        $products=$session->get('products');
        // TODO: если товар имеет свойства, влияющие на цену, тогда $products_s[$id]['prop1_id']['count']         
        $products[$goods_id]['count'] = $count;
        // добавляем товар в сессию
        $session->set('products',$products);         

        // запускаем виджет карзины, который по сессионной переменной формирует карзину
        $cart_widget = CartWidget::widget(["no_wrap"=>true]);
        echo json_encode(array("ok"=>"true","cart_widget"=>$cart_widget));
        exit;
    }

    //оформить заказ
    public function actionIssue(){
       $goods = self::getCart();

        //вход\регистрация
        if (\Yii::$app->user->isGuest) {
            $LoginModel = new LoginForm(); //модель авторизации
            $signModel = new SignupForm(); //модель регистрации

            if ($LoginModel->load(Yii::$app->request->post()) && $LoginModel->login()) {
                if (Yii::$app->user->can('user')) {
                    return $this->redirect('/cart/issue', 302);
                }
            }

            if ($signModel->load(Yii::$app->request->post())) {
                if ($user = $signModel->signup()) {
                    if (Yii::$app->getUser()->login($user)) {
                        return $this->redirect('/cart/issue', 302);
                    }
                }
            }
        }else{
            $model = User::findOne(Yii::$app->getUser()->id);
            // обработка данных корзины
            if($model->load(Yii::$app->request->post()) && $model->validate()){
                $postData = Yii::$app->request->post();
                $delivery_sum = 0;
                //сумма доставки по районам
                if(isset($postData['district'])){
                    $delivery_sum = abs((int)$postData['district']);
                }
                //сумма доставки другие города
                if($postData['User']['delivery']=='city'){
                    $delivery_sum = 1000;
                }
                // дамп карзины
                $cart = json_encode($goods);
                $all_sum = 0;
                foreach($goods as $g){
                    $all_sum = $all_sum + $g['price']*$g['count'];
                }
                // итоговая сумма
                $all_sum = $all_sum + $delivery_sum;

                if($all_sum!=0){
                    //сохраним телефон и адрес если нет
                    $model->save();
                    //создаем заказ
                    $orderModel = new Orders();
                    $orderModel->user_id = $model->id;
                    $orderModel->sum_total = $all_sum;
                    $orderModel->sum_delivery = $delivery_sum;
                    $orderModel->create_date = date("Y-m-d H:i:s");
                    $orderModel->dump_cart = $cart;
                    $orderModel->comment = $model->comment;
                    $orderModel->save();
                    //связь заказа и товаров
                    foreach($goods as $good){
                        $ordersGoods = new OrdersGoods();
                        $ordersGoods->order_id = $orderModel->id;
                        $ordersGoods->good_id = $good['id'];
                        $ordersGoods->save();
                    }
                    //отправляем письмо с заказом и удаляем корзину
                    $orderModel->sendEmail($goods, $delivery_sum,$orderModel->id);
                    $orderModel->sendEmailAdmin($goods, $delivery_sum,$orderModel->id);
                    $session = new Session;
                    $session->open();
                    $session->remove('products');
                    return $this->redirect('/', 302);
                }
            }
        }

        return $this->render('issue',  [
            'goods'=>$goods,
            'model'=>$model,
            'LoginModel'=>$LoginModel,
            'signModel'=>$signModel,
        ]);
    }

    /*
     * Личный кабинет
     */
    public function actionAccount(){
        if (\Yii::$app->user->isGuest) {
            return $this->redirect('/', 302);
        }

        $db = Yii::$app->db;
        $id_user = Yii::$app->getUser()->id;
        $orders = $db->createCommand("SELECT * FROM orders WHERE user_id = '$id_user'")->queryAll();

        $compareUserModel = new CompareUser();

        if ($compareUserModel->load(Yii::$app->request->post()) && $compareUserModel->validate()) {
            if($compareUserModel->generateNewPassword($compareUserModel->password_new)){
                \Yii::$app->getSession()->setFlash('pass_complete', 'Пароль успешно изменен');
                return $this->redirect('/account', 302);
            }else{
                \Yii::$app->getSession()->setFlash('pass_error', 'Ошибка изменения пароля');
                return $this->redirect('/account', 302);
            }
        }

        return $this->render('account',  [
            'orders'=>$orders,
            'compareUserModel'=>$compareUserModel,
        ]);
    }


}
