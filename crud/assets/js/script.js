// alert('OK');
document.addEventListener('DOMContentLoaded', function(){
    // console.log('loaded');
    var links = document.querySelectorAll(".delete");
    for(i = 0; i < links.length; i++){
        links[i].addEventListener('click', function(e){
            if(!confirm('Are you sure to delete?')){
                e.preventDefault();
            }
        });
    }

});