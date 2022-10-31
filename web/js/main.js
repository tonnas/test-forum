$(function() {
    $('button.modalButton').on('click', function (){
        showModal($(this).attr('value'))
    });
    $('a.modalButton').on('click', function (e){
        e.preventDefault()
        showModal($(this).attr('href'))
    });
});

function showModal(linkToBeLoad) {
    $('.modal').modal('show')
        .find('#modalContent')
        .load(linkToBeLoad);
}