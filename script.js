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


function copy(text) {
    let TempText = document.createElement("input");
    TempText.value = text;
    document.body.appendChild(TempText);
    TempText.select();
    document.execCommand("copy");
    document.body.removeChild(TempText);
    alert("تم النسخ");
}

$('.copy').click(function () {
    let copyid = $(this).attr('id');
    let copyPostid = copyid.substring(1);
    let wantedElement = document.getElementById(copyPostid);
    copy(wantedElement.innerText);
});