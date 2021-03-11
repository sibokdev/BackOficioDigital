jQuery(document).ready(function() {

    var content,folio_modal=$('.folio-modal'),folio_modal_content, clarification, folio_all, token,
        folio,folio_drop_down=$('.solution-from-drop-down'), folio_field=$('.folio-field'),
        solution_modal=$('.solution-modal'),folio_input;

    $(".aclaracion").on("click", function () {
        content = $(this).data("contenido");
        $(".aclaracion-text").html(content);

        folio_modal_content=$(this).data('folio');
        folio_modal.val(folio_modal_content);
    });



    //Begin script of folio in solution modal
        folio_drop_down.on('click',function(){
            folio=$(this).data('folio');
            folio_field.val(folio);
        });

        solution_modal.on('click',function(){
            folio_input=document.getElementById('folio-modal').value;
            folio_field.val(folio_input);
        });
    //End script of folio in solution modal


    //Begin script Editors
    ComponentsEditors.init();
    //End script of solution

});