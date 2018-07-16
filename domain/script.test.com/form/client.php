<?php 

session_start();

?>

<form action="http://api.test.com/form/server.php" method="post">
	<input type="text" name="foo" value="bar"/>
	<input type="submit"/>
</form>

<!-- 

# 课题：网站A的表单，提交到网站B时，是否会携带A站的cookie或B站的cookie？

# 结论：会携带B站的cookie（前提当然是当前浏览器窗口已访问过B站）。
  
# 这就是CSRF攻击的原理

# https://www.zhihu.com/question/31592553【为什么form表单提交没有跨域问题，但ajax提交有跨域问题】

-->