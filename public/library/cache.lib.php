<?php
/**
 * 基础缓存类接口
 *
 * @author	matengfei
 * @date	2015-11-08
 */
define('CACHE_DIR_NUM', 20000); //缓存目录数量，根据预期缓存文件数调整，开根号即可
class CacheServer {
	
    var $_options = null;
    
    /**
	 * 构造函数
	 */
    function __construct($options = null){
        $this->_options = $options;
    }
    
    /**
	 * 析构函数
	 */
	function __destruct(){}
	
	/**
	 * 设置缓存
	 *
	 * @author	matengfei
	 * @param	string $key
	 * @param	mixed $value
	 * @param	int $ttl 缓存时间
	 * @return 	bool
	 */
    function set($key, $value, $ttl = 0){}
	
    /**
	 * 获取缓存的数据
	 *
	 * @author	matengfei
	 * @param	string $key
	 * @return 	mixed
	 */
    function &get($key){}
 
    /**
	 * 清空缓存
	 *
	 * @author	matengfei
	 * @param 	void
	 * @return 	bool
	 */
    function clear(){}
    
    /**
	 * 删除一个缓存
	 *
	 * @author	matengfei
	 * @param	string $key
	 * @return 	bool
	 */
	function delete($key){}
	
}

/**
 * 普通PHP文件缓存
 *
 * @author	matengfei
 * @date	2015-11-08
 */
class PhpCacheServer extends CacheServer {
	
    /* 缓存目录 */
    var $_cache_dir = './';
    
    /**
	 * 构造函数
	 */
    function __construct($options){}
    
    /**
	 * 析构函数
	 */
    function __destruct(){}
    
    /**
	 * 设置缓存
	 *
	 * @author	matengfei
	 * @param	string $key
	 * @param	mixed $value 要存储的值，字符串和数值直接存储，其他类型序列化后存储。
	 * @param	int $ttl 当前写入缓存的数据的失效时间。如果此值设置为0表明此数据永不过期。你可以设置一个UNIX时间戳或 以秒为单位的整数（从当前算起的时间差）来说明此数据的过期时间，但是在后一种设置方式中，不能超过 2592000秒（30天）。
	 * @return  bool
	 */
    function set($key, $value, $ttl = 0){
        if (!$key) {
            return false;
        }
        $cache_file = $this->_get_cache_path($key);
        $cache_data = "<?php\r\n/**\r\n *  @Created By matengfei PhpCacheServer\r\n *  @Time:" . date('Y-m-d H:i:s') . "\r\n */";
        $cache_data .= $this->_get_expire_condition(intval($ttl));
        $cache_data .= "\r\nreturn " . var_export($value, true) .  ";\r\n";
        $cache_data .= "\r\n?>";
        return file_put_contents($cache_file, $cache_data, LOCK_EX);
    }
    
    /**
	 * 获取缓存
	 *
	 * @author	matengfei
	 * @param	string $key
	 * @return  mixed
	 */
    function &get($key){
        $cache_file = $this->_get_cache_path($key);
        if (!is_file($cache_file)) {
            return false;
        }
        $data = include($cache_file);
        return $data;
    }
    
    /**
	 * 清空缓存
	 *
	 * @author	matengfei
	 * @param 	void
	 * @return  bool
	 */
    function clear(){
        $dir = dir($this->_cache_dir);
        while (false !== ($item = $dir->read())) {
            if ($item == '.' || $item == '..' || substr($item, 0, 1) == '.') {
                continue;
            }
            $item_path = $this->_cache_dir . '/' . $item;
            if (is_dir($item_path)) {
                ecm_rmdir($item_path);
            } else {
                _at(unlink, $item_path);
            }
        }
        return true;
    }
    
    /**
	 * 删除缓存
	 *
	 * @author	matengfei
	 * @param	string $key
	 * @return  bool
	 */
    function delete($key){
        $cache_file = $this->_get_cache_path($key);
        return _at(unlink, $cache_file);
    }
    
    /**
	 * 设置缓存路径
	 *
	 * @author	matengfei
	 * @param	string $path
	 * @return  void
	 */
    function set_cache_dir($path){
        $this->_cache_dir = $path;
    }
    
    /**
	 * 获取过期条件
	 *
	 * @author	matengfei
	 * @param	int $ttl 当前写入缓存的数据的失效时间。如果此值设置为0表明此数据永不过期。你可以设置一个UNIX时间戳或 以秒为单位的整数（从当前算起的时间差）来说明此数据的过期时间，但是在后一种设置方式中，不能超过 2592000秒（30天）。
	 * @return  string
	 */
    function _get_expire_condition($ttl = 0){
        if (!$ttl) {
            $ttl = CACHE_TIME;
        }
        return "\r\n\r\n" . 'if(filemtime(__FILE__) + ' . $ttl . ' < time())return false;' . "\r\n";
    }
    
    /**
	 * 获取缓存路径
	 *
	 * @author	matengfei
	 * @param	string $key
	 * @return  string
	 */
    function _get_cache_path($key){
        $dir = str_pad(abs(crc32($key)) % CACHE_DIR_NUM, 4, '0', STR_PAD_LEFT);
        ecm_mkdir($this->_cache_dir . '/' . $dir);
        return $this->_cache_dir . '/' . $dir .  '/' . $this->_get_file_name($key);
    }
    
    /**
	 * 设置缓存文件名称
	 *
	 * @author	matengfei
	 * @param	string $key
	 * @return  string
	 */
    function _get_file_name($key){
        return md5($key) . '.cache.php';
    }
        
}

/**
 * memcached缓存类
 *
 * @author	matengfei
 * @date	2015-11-08
 */
class MemcacheServer extends CacheServer {
	
    var $_memcache = null;
    
    /**
	 * 构造函数
	 */
    function __construct($options){
        parent::__construct($options);

        /* 连接到缓存服务器 */
        $this->connect($this->_options);
    }
    
    /**
	 * 析构函数
	 */
    function __destruct(){
    	$this->_memcache->close();
    }

 	/**
	 * 连接到缓存服务器
	 *
	 * @author	matengfei
	 * @param	array $options
	 * @return  bool
	 */
    function connect($options){
        if (empty($options)) {
            return false;
        }
        $this->_memcache = new Memcache;
        return $this->_memcache->connect($options['host'], $options['port']);
    }

    /**
	 * 设置缓存
	 *
	 * @author	matengfei
	 * @param	string $key
	 * @param	mixed $value 要存储的值，字符串和数值直接存储，其他类型序列化后存储。
	 * @param	int $ttl 当前写入缓存的数据的失效时间。如果此值设置为0表明此数据永不过期。你可以设置一个UNIX时间戳或 以秒为单位的整数（从当前算起的时间差）来说明此数据的过期时间，但是在后一种设置方式中，不能超过 2592000秒（30天）。
	 * @return  bool
	 */
    function set($key, $value, $ttl = 0){
    	if (!$ttl) {
    		$ttl = CACHE_TIME;
    	}    	
        return $this->_memcache->set($key, $value, MEMCACHE_COMPRESSED, $ttl);
    }
    
    /**
	 * 获取缓存
	 *
	 * @author	matengfei
	 * @param	string $key
	 * @return  mixed
	 */
    function &get($key){
    	$data = $this->_memcache->get($key);
        return $data;
    }
    
    /**
	 * 清空缓存
	 *
	 * @author	matengfei
	 * @param 	void
	 * @return  bool
	 */
    function clear(){
        return $this->_memcache->flush();
    }
	
    /**
	 * 删除缓存
	 *
	 * @author	matengfei
	 * @param	string $key
	 * @return  bool
	 */
    function delete($key){
        return $this->_memcache->delete($key);
    }
    
}

/**
 * redis缓存类
 *
 * @author	matengfei
 * @date	2015-11-08
 */
class RedisServer extends CacheServer{

    private $_redis; //redis对象
    private $compressed;

    /**
     * 初始化Redis
     * 
     * $config = array(
     *     'server' => '127.0.0.1', //服务器
     *     'port'   => '6379', //端口号
     * );
     * @param array $options
     */
    public function __construct($options) {
        parent::__construct($options);
        $this->_redis = new Redis();
        $this->_redis->connect($options['host'], $options['port']);
        if (defined('CACHE_ID')) {
            $this->_redis->select(CACHE_ID);
        }
        if (defined('CACHE_COMPRESSED')) {
            $this->compressed = CACHE_COMPRESSED;
            $this->compressed = (int)$this->compressed;
        }
    }
    
    /**
     * 析构函数
     */
    function __destruct(){
        $this->_redis->close();
    }

    /**
     * 设置值
     * @param string $key KEY名称
     * @param string|array $value 获取得到的数据
     * @param int $timeOut 时间
     */
    public function set($key, $value, $timeOut = 0) {
        if ($value === false) return false;
        $value = json_encode($value, true);
        $retRes = $this->_redis->set($key, $value);
        if ($timeOut > 0) $this->_redis->setTimeout($key, $timeOut);
        return $retRes;
    }

    /**
     * 通过KEY获取数据
     * @param string $key KEY名称
     */
    public function &get($key) {
        $result = $this->_redis->get($key);
        if ($this->compressed) $result = gzuncompress($result);
        
        $value = json_decode($result, true);
        if ($value === false) {
            return $result;
        }
        return $value;
    }

    /**
     * 删除一条数据
     * @param string $key KEY名称
     */
    public function delete($key, $delay = 0) {
        if ($delay == 0) {
            return $this->_redis->delete($key);
        } else {
            return $this->_redis->setTimeout($key, $delay);
        }    
    }

    /**
     * 清空数据
     */
    public function flushAll() {
        return $this->_redis->flushAll();
    }

    /**
     * 数据入队列
     * @param string $key KEY名称
     * @param string|array $value 获取得到的数据
     * @param bool $right 是否从右边开始入
     */
    public function push($key, $value ,$right = true) {
        $value = json_encode($value);
        return $right ? $this->_redis->rPush($key, $value) : $this->_redis->lPush($key, $value);
    }

    /**
     * 数据出队列
     * @param string $key KEY名称
     * @param bool $left 是否从左边开始出数据
     */
    public function pop($key , $left = true) {
        $val = $left ? $this->_redis->lPop($key) : $this->_redis->rPop($key);
        return json_decode($val);
    }

    /**
     * 数据自增
     * @param string $key KEY名称
     */
    public function increment($key) {
        return $this->_redis->incr($key);
    }

    /**
     * 数据自减
     * @param string $key KEY名称
     */
    public function decrement($key) {
        return $this->_redis->decr($key);
    }

    /**
     * key是否存在，存在返回ture
     * @param string $key KEY名称
     */
    public function exists($key) {
        return $this->_redis->exists($key);
    }

    /**
     * 返回_redis对象
     * _redis有非常多的操作方法，我们只封装了一部分
     * 拿着这个对象就可以直接调用_redis自身方法
     */
    public function _redis() {
        return $this->_redis;
    }
    
}
?>