<?php
// Headers

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

$database = new Database();
$db = $database->connect();

$post = new Post($db);

// Blog post Query
$result = $post->read();
// Get row count
$num = $result->rowCount();

// Check if any posts
if($num > 0){
    // Post array
    $post_array = array();
    $post_array['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $post_item = array(
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name
        );

        // push to data
        array_push($post_array['data'], $post_item);
    }

    // turn to json ouput
    echo json_encode($post_array);

}else{
    // no post
    echo json_encode(
        array('message' => 'No posts found')
    );
}