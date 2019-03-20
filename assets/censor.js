
class Censorshipy {
  constructor() {
    this.checkboxes = $('input[type=checkbox]');
    this.inputsToCheck = $('.form-table__option-left');
    this.events();
  }

  events() {
    this.checkboxes.on('click', this.validateRow );
    this.inputsToCheck.on('keyup', this.validateRow);
    $('.form-table__option-right').on('keyup', this.validateRow);
    $(document).ready(this.validateForm);
  }

  validateForm() {
    console.log('lets validate our form');
  }

  validateRow(e) {
    var target = $(e.target),
      inputLeft = target.closest('tr').find('.form-table__option-left'),
      inputRight = target.closest('tr').find('.form-table__option-right'),
      rowCheckboxes = target.closest('tr').find('input[type="checkbox"]'),
      checkInput = false;

      rowCheckboxes.each(function() {
        if (this.checked)
          checkInput = true;
      })

      if (!inputLeft.val() && checkInput) {
        inputLeft.addClass('invalid');
      } else {
        inputLeft.removeClass('invalid');
      }

      if (inputLeft.val() && !checkInput) {
        rowCheckboxes.each(function() {
          $(this).addClass('invalid');
        })
      } else {
        rowCheckboxes.each(function() {
          $(this).removeClass('invalid');
        })
      }

      if (inputRight.val() && !inputLeft.val()) {
        inputLeft.addClass('invalid');
      }

  }
}

$(function() {
  var censorshipy = new Censorshipy();
})
