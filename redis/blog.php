<?php
	include './common.php';
	$id=$redis->get('article_id')-1;
	$article_id='article:'.$id;
	$article=$redis->hgetAll($article_id);
?>

<table>
	<tr>
		<td>文章标题</td>
		<td><?php echo $article['title'] ?></td>
	</tr>
	<tr>
		<td>文章内容</td>
		<td><?php echo $article['content'] ?></td>
	</tr>
	<tr>
		<td>发布时间</td>
		<td><?php echo $article['pubtime'] ?></td>
	</tr>
	<tr>
		<td>作者</td>
		<td><?php echo $article['author'] ?></td>
	</tr>	
</table>
