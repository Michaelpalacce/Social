var postId=0;
var postBodyElement=null;

$('.post').find('.interaction').find('.edit').on('click',function(event){
    event.preventDefault();
    postBodyElement=event.target.parentNode.parentNode.childNodes[1];
    var postBody=postBodyElement.textContent;
    postId = $(this).parents('.post').attr('data-postId');
    $('#post-body').val(postBody);
    $('#edit-modal').modal();
});


$('#modal-save').on('click',function(){
    var body=$('#post-body').val();

    $.ajax({
        url: urlEdit,
        type:"POST",
        data: {body: body,postId: postId,_token: token}
    }).done(function(msg){
        $(postBodyElement).text(msg['new_body']);
        $('#edit-modal').modal('hide');
    });
});

$('.like').on('click', function (event) {
    event.preventDefault();
    postId = event.target.parentNode.parentNode.dataset['postid'];
    var isLike = event.target.previousElementSibling == null;
    $.ajax({
        url: urlLike,
        method:"POST",
        data: {isLike: isLike,postId: postId,_token: token}
    }).done(function() {
        event.target.innerText = isLike ? event.target.innerText == 'Like' ? 'You like this post' : 'Like' : event.target.innerText == 'Dislike' ? 'You don\'t like this post' : 'Dislike';
        if (isLike) {
            event.target.nextElementSibling.innerText = 'Dislike';
        } else {
            event.target.previousElementSibling.innerText = 'Like';
        }
    });
});