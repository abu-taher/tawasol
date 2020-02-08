$(document).ready(function () {
  $('input[type="radio"]').click(function () {
    var requireClass = $(this).attr("value");
    if (requireClass === 'business') {
      $("#business_class_options").show();
    } else {
      $("#business_class_options").hide();
      var selectedMeal = $("#preferred_meal");
      var notes = $("#notes");
      selectedMeal.val("");
      notes.val("");
    }
  });
});