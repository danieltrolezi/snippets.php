<?php

class PostsRepository
{
	private const API_URL = 'https://coderbyte.com/api';

	public function getPostsAndComments(): string
	{
  	$posts = $this->call('/challenges/json/all-posts');
  	$comments = $this->call('/challenges/json/all-comments');
 	 
  	$posts = $this->mergePostsAndComments($posts, $comments);
  	$posts = $this->filterPosts($posts);
  	$posts = $this->sortCollectionById($posts);

  	return json_encode($posts);
	}

	private function call(string $path): array
	{
    	$ch = curl_init(self::API_URL . $path);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch, CURLOPT_HEADER, 0);
    	$data = curl_exec($ch);
    	curl_close($ch);

    	return json_decode($data, true);
	}

	private function mergePostsAndComments(array $posts, array $comments): array
	{
    	$postIds = array_column($posts, 'id');
    	$commentsByPost = $this->groupCommentsByPost($comments);

    	foreach($commentsByPost as $postId => $postComments) {
        	$postIndex = array_search($postId, $postIds);
        	$posts[$postIndex]['comments'] = $this->sortCollectionById($postComments);   
    	}

    	return $posts;
	}
    
	private function groupCommentsByPost(array $comments): array
	{
    	$commentsByPost = [];

    	foreach($comments as $comment) {
        	$postId = $comment['postId'];

        	if(!isset($commentsByPost[$postId])) {
            	$commentsByPost[$postId] = [];
        	}

        	$commentsByPost[$postId][] = $comment;
    	}

    	return $commentsByPost;
	}

	private function filterPosts(array $posts)
	{
    	$startDate = new DateTime('2021-01-02 00:00:00');
    	$endDate = new DateTime('2024-01-02 23:59:59');

    	return array_filter($posts, function($post) use($startDate, $endDate) {
        	$createdAt = new DateTime($post['created_at']);

        	return $post['userId'] === 1
              	&& $createdAt >= $startDate
              	&& $createdAt <= $endDate
              	&& !empty($post['comments']);
    	});
	}

	private function sortCollectionById(array $collection): array
	{
    	usort($collection, function($a, $b){
        	return $a['id'] > $b['id'] ? 1 : 0;
    	});

    	return $collection;
	}
}


$repository = new PostsRepository();
print_r(
  $repository->getPostsAndComments()
);

?>
