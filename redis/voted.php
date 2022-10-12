<?php
/**
* 投票
**/
	include './common.php';
	$vote_score=432;
	$article_id='article:2';
	echo "投票前分值：".$redis->zscore('article_voted',$article_id)."<br>";
	$ret=$redis->zincrby('article_voted',$vote_score,$article_id);
	echo "投票后分值:".$ret;

