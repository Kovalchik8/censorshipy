
class Censorshipy {
  constructor() {
    this.events();
  }

  events() {
    $('input[type=checkbox]').on('click', this.validateOnEvent.bind(this) );
    $('.form-table__option-left').on('keyup', this.validateOnEvent.bind(this));
    $('.form-table__option-right').on('keyup', this.validateOnEvent.bind(this));
    $(document).ready(this.validateOnLoad.bind(this));
  }

  // validate each row in our table
  validateOnLoad() {
    var rows = $('.form-table tr:not(.form-table__top)'),
        that = this;

    rows.each(function() {
      var checkboxes = $(this).find('input[type=checkbox]'),
          inputLeft = $(this).find('.form-table__option-left'),
          inputRight = $(this).find('.form-table__option-right');
      
      that.validateTableRow(checkboxes, inputLeft, inputRight);
    })

  }

  // validate certain row
  validateOnEvent(e) {
    var target = $(e.target),
      checkboxes = target.closest('tr').find('input[type="checkbox"]'),
      inputLeft = target.closest('tr').find('.form-table__option-left'),
      inputRight = target.closest('tr').find('.form-table__option-right');

      this.validateTableRow(checkboxes, inputLeft, inputRight);

  }

  // validation process for a row
  validateTableRow(checkboxes, inputLeft, inputRight) {
    var checkInput = false;

    checkboxes.each(function() {
      if (this.checked)
        checkInput = true;
    })

    if (!inputLeft.val() && checkInput) {
      inputLeft.addClass('invalid');
    } else {
      inputLeft.removeClass('invalid');
    }

    if (inputLeft.val() && !checkInput) {
      checkboxes.each(function() {
        $(this).addClass('invalid');
      })
    } else {
      checkboxes.each(function() {
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
