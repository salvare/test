<?php
require 'public.php';

// private_key_bits=384 最高加密37bytes明文，密文48bytes
$pub = 'MEwwDQYJKoZIhvcNAQEBBQADOwAwOAIxANOsHZ2/pMWCrxy9dSxr+34CYHO2PZANtYwEMEWLcLLGe0VAL1i9sJPWdycT43u+cQIDAQAB';
$pri = 'MIIBDAIBADANBgkqhkiG9w0BAQEFAASB9zCB9AIBAAIxANOsHZ2/pMWCrxy9dSxr+34CYHO2PZANtYwEMEWLcLLGe0VAL1i9sJPWdycT43u+cQIDAQABAjEAlzd3dPGrIdrphMuogNKnuO6zvxZrRpUzV5XR+38wYOL2+uYaobkVzF4tFd7431LBAhkA7412kL4BC8hiWLz5n6EDwIaUYUkg7v15AhkA4jScP8c94iXEd8zsumBrSmQw5bD1YKK5AhkAuyPqYjztGEVc/zHyWNAy3C7GsBGvFsURAhkAok9fwj/Dvq6c391yC3W95p4nm9iy6Qk5AhhSp2lsADfYTqNS/HNSslRpcsQPxvnxOYM=';
// private_key_bits=512 最高加密53bytes明文，密文64bytes
// $pub = 'MFwwDQYJKoZIhvcNAQEBBQADSwAwSAJBAOqflPqewguMXUFdtgMPyGfKHyYoh4CJo2suCS5OZ8v2uKGnEnk6WGcDsH4T5pg/dqmllmVK5hwDXcWz6YExixsCAwEAAQ==';
// $pri = 'MIIBVgIBADANBgkqhkiG9w0BAQEFAASCAUAwggE8AgEAAkEA6p+U+p7CC4xdQV22Aw/IZ8ofJiiHgImjay4JLk5ny/a4oacSeTpYZwOwfhPmmD92qaWWZUrmHANdxbPpgTGLGwIDAQABAkEA5e0n0Yd9gFW5GhLdCRkRe20fo4R6biP0a1e9FY0uuTiak12XSNQQpoQLIhCNHOle5Xd7UEPw5qm/WaM2mEgU8QIhAPUhehQW8G1jv4kM7Oh/ZX6uGTodJQgJOUciZ0vQpxjzAiEA9QbVbEai9YWAaFt7VNOJhTDZ89ui6km81cChQeoOTzkCIA3pC2tubdBXU7wsPplm+VR5/rZ8huhw1Y5C1ofH3GOfAiEA5b4flONyXnVrne3Q6QtjUVApvB2/VqAHAAEa8lvMSPkCIQDzG29vcWIc4gvi4il6aC6lrxM+HgS/HtUsvKO46lF/aQ==';
// private_key_bits=1024 最高加密117bytes明文，密文128bytes
// $pub = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC7KlcjjbNl1ok0obMtQIdYvH9tBBGeTUSRnRRc8z5I/sX/AA9Ob3RgD+Pl1I2r3vEI+PwHyhV6PtEdlMb/V5ThYggD6XlWc+Ixb/un0SmT/fQU6/oU7Nk6iKOsq9W4h8C91CARS1QAsaFJcEYn3fkDE6iM2/dE0uCgaCHcTQfWrQIDAQAB';
// $pri = 'MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBALsqVyONs2XWiTShsy1Ah1i8f20EEZ5NRJGdFFzzPkj+xf8AD05vdGAP4+XUjave8Qj4/AfKFXo+0R2Uxv9XlOFiCAPpeVZz4jFv+6fRKZP99BTr+hTs2TqIo6yr1biHwL3UIBFLVACxoUlwRifd+QMTqIzb90TS4KBoIdxNB9atAgMBAAECgYEAgt+OYvv4j6M9+aF/6oqOmYvlBlOsBic9ZRyTWpNz4BLWXAKssUnZ9DnoP5MrJR0VKhMAGGpELmCyVJ7tryqMnQBMlVQwLW3H05Om/CPRZhxPgcg1lqxibk5Q361VWQpNwTVcYfGHYwUAIlMhhhmQwBRdxGjAwsMtj7fIAkNJwDkCQQD3O7ZPHyj7sKu6wlMDqo8+7SV1AGP9Xomc65/7Y+bU22xHmd0c79q0ssWWGCrawowErUA25eAEggilS2aIZ7rPAkEAwc1a/qQhv+SOo0cHt8G1catixMCD+ggCu/ivBCUMqLlj5kEjWwqBvGze76pjsdkyh7bzoQcvRFQ7EJzGcFmFwwJAK801eIEhxq2/TyA8iuq95D0ppLgD/xCvutB4EJbbf5y8a1cUOJs6GUePAA+aEBXlrrJvLQq/DK1pELfyG3qdOwJARXUT569raRrBBEOwwGrsXJDQFTPqGPJGCJhYIWQl5VKMOzmdMkPRu3ZJcBvhHxx4v6sSJeQtTI/jm1CUzi9HgQJBAOJUqaS0jV3XKZOeb6Hs05R8ouLTYXp5qhV+mAHhJf2Ywx88BpN3t3fHVR4UvubKCWk57tChN59N2NLbRzoVMFs=';
dump($pub);
dump(base64_decode($pub));
dump(strlen(base64_decode($pub)));
dump($pri);
dump(base64_decode($pri));
dump(strlen(base64_decode($pri)));

?>
<!-- 

# 以上是`private_key_bits`参数值为`384|512|1024`时生成的3对秘钥
  . 秘钥的格式如`-----BEGIN PUBLIC KEY-----XXXXXXXX-----END PUBLIC KEY-----`和
    `-----BEGIN PRIVATE KEY-----XXXXXXXXX-----END PRIVATE KEY-----`
  . `XXXXXXXXX`中应该包含 指数和模值（格式不明）

# https://blog.csdn.net/lvxiangan/article/details/45487943【RSA密钥长度、明文长度和密文长度】【important】
  . 文中`秘钥长度`、`模值长度`，就是PHP openssl方法`openssl_pkey_new`中的`private_key_bits`参数
  ? 公钥指数/私钥指数 概念不明（见下）
  ? 模值的取值和素数的生成有关，因为效率问题，不一定能准确生成指定位数（二进制位数）的素数，只是生成一个“接近1024位的素数而已” <- 理解这个反而引起混淆
  . PKCS1Padding下，明文长度=密钥长度-11。如：private_key_bits=1024bits=128bytes，明文长度至多128-11=117bytes
  . 密文长度=密钥长度
  
# https://blog.csdn.net/dbs1215/article/details/48953589【RSA算法原理】【excellent】
  ↑ `密文＝明文^E%N`，`明文＝密文^D%N`，`私钥＝(D,N)`，`公钥＝(E,N)`，
  . E 是公钥指数
  . D 是私钥指数
  . N 是模值，是两个（？）素数的积，长度是秘钥长度
  * 这是纯数学角度的RSA算法
  
？ 为什么需要填充(PADDING)
  . https://zhidao.baidu.com/question/1303282736275569219.html


-->