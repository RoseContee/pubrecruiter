<div class="blog-comments-item">
    <hr>
    <p class="m-0">Name: <b>{{ $comment['name'] }}</b></p>
    <p>{{ $comment['comment'] }}</p>
    <p class="small m-0">{{ date('F j, Y g:i A', strtotime($comment['created_at'])) }}</p>
</div>
