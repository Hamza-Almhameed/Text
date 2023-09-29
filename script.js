let loader = document.getElementById('loader');
window.onload = function () {
    loader.style.display = 'none';
}


$('.like').click(function () {
    
    let postid = $(this).attr('id');
    $.ajax({
        url: 'index.php',
        type: 'post',
        async: false,
        data: {
            'liked': 1,
            'postid': postid
        },

        success:function(){

        }
    });
    
});


$('.unlike').click(function () {
    let postid = $(this).attr('id');
    $.ajax({
        url: 'index.php',
        type: 'post',
        async: false,
        data: {
            'unliked': 1,
            'postid': postid
        },

        success:function(){

        }
    });
});