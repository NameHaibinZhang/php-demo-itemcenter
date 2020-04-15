<?php

/**
 * 数据操作类
 */
class Request
{
    //允许的请求方式
    private static $method_type = array('get', 'post', 'put', 'patch', 'delete');
    //测试数据
    private static $item_array = array(
        1000 => array('name' => 'Coffee', 'price' => 100),
        1001 => array('name' => 'tea', 'count' => 101),
    );

    public static function getRequest()
    {
        //请求方式
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        if (in_array($method, self::$method_type)) {
            //调用请求方式对应的方法
            $data_name = $method . 'Item';
            return self::$data_name($_REQUEST);
        }
        return false;
    }

    //GET 获取item
    private static function getItem($request_data)
    {
        $item_id = (int)$request_data['itemId'];
        if ($item_id > 0) {
            return self::$item_array[$item_id];
        } else {
            return self::$item_array;
        }
    }

    //POST /item 新增一个商品
    private static function postItem($request_data)
    {
        if (!empty($request_data['name'])) {
            $data['name'] = $request_data['name'];
            $data['price'] = (int)$request_data['price'];
            self::$item_array[] = $data;
            return self::$item_array;//返回新生成的资源对象
        } else {
            return false;
        }
    }

    //PUT /item/ID：更新某个商品的信息）
    private static function putItem($request_data)
    {
        $item_id = (int)$request_data['itemId'];
        if ($item_id == 0) {
            return false;
        }
        $data = array();
        if (!empty($request_data['name']) && isset($request_data['price'])) {
            $data['name'] = $request_data['name'];
            $data['price'] = (int)$request_data['price'];
            self::$item_id[$item_id] = $data;
            return self::$item_array;
        } else {
            return false;
        }
    }

    //PATCH 
    private static function patchItem($request_data)
    {
        $item_id = (int)$request_data['itemId'];
        if ($item_id == 0) {
            return false;
        }
        if (!empty($request_data['name'])) {
            self::$item_array[$item_id]['name'] = $request_data['name'];
        }
        if (isset($request_data['price'])) {
            self::$item_array[$class_id]['price'] = (int)$request_data['price'];
        }
        return self::$item_array;
    }

    //DELETE /item/ID：删除商品
    private static function deleteItem($request_data)
    {
        $item_id = (int)$request_data['itemId'];
        if ($item_id == 0) {
            return false;
        }
        unset(self::$item_array[$item_id]);
        return self::$item_array;
    }
}
