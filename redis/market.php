<?php
	include_once './common.php';
	$redis->select(1);
	$goodsList_market=$redis->zrange('market',0,5,true);
	$goodsList_self=$redis->smembers('inventory:17');
	$info=$redis->hgetall('user:17');
?>

<h3>商品列表</h3>
<ul>
	<?php foreach($goodsList_market as $goods=>$price){ ?>
	<li><?php echo $goods ?><span>￥<?php echo $price ?></span><a href="buy.php?goodsname=<?php echo $goods?>&price=<?php echo $price?>">购买</a></li>
	<?php } ?>
</ul>

<h3>余额: ￥<?php echo $info['money'] ?></h3>	

<form action="grounding.php" method="post">
<input type="hidden" name="userid" value="17">
选择商品:<select name="goodsname">
			<?php foreach($goodsList_self as $vo){ ?>
			<option value="<?php echo $vo ?>"><?php echo $vo ?></option>
			<?php } ?>	
		</select>
		<br>
商品价格:<input type="number" name="price" >		
<br>
<input type="submit" value="提交">
</form>
