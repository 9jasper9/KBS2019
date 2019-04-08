$("#sort").change(function() {
    $("#sort-form").submit();
});

$(".cartamount").change(function() {
    $(this).parents('form:first').submit();
});

$("#amount").change(function() {
    $("#product-amount").submit();
});

$("#product-type-select").change(function () {
    window.location.href = $(this).find('option:selected').data('href');
});