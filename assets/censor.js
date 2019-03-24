
class Censorshipy {

  constructor() {
    this.inputTableRows = $('.form-table__rows-cnt');
    this.addRowBtn = $('.form-table__add');
    this.addRowBtn.on('click', this.addRowBtnOnClick.bind(this))
    this.tableBody = $('.form-table tbody');
    this.deleteRowTrigger();
    this.validationEvents();
  }

  // events
  deleteRowTrigger() {
    $('.form-table__delete').on('click', this.deleteRow.bind(this));
  }

  validationEvents() {
    $('input[type=checkbox]').on('click', this.validateOnEvent.bind(this) );
    $('.form-table__option-left, .form-table__option-right').on('keyup', this.validateOnEvent.bind(this));
    $(document).ready(this.validateOnLoad.bind(this));
  }

  // methods
  setTableRows() {
    var rows = $('.form-table tr:not(.form-table__top)'); // exclude table headers row
    this.inputTableRows.val(rows.length); 
  }

  deleteRow(e) {
    var currentRow = $(e.target).closest('tr');
    currentRow.remove();

    // resign all rows options
    var raws = $('.form-table tr:not(.form-table__top)');
    raws.each(function(index) {
      index++;
      $(this).find('.form-table__number').text(index);
      $(this).find('.form-table__option-left').attr('name', 'option-left-' + index);
      $(this).find('.form-table__option-right').attr('name', 'option-right-' + index);
      
      var checkboxes = $(this).find('input[type=checkbox]'),
          checkboxesOptions = ['title-', 'content-', 'comments-'];
      
      checkboxes.each(function(i) {
        $(this).attr('name', checkboxesOptions[i] + index)
      })

    })

    this.setTableRows();
    this.addRowBtn.removeClass('hidden');

  }

  addRowBtnOnClick() {
    var tableRows = $('.form-table tr');

    if (tableRows.length < ajax_object.max_table_rows ) {
      var i = tableRows.length;
      this.tableBody.append(`
      
      <tr valign="top">
        <th class="form-table__number" scope="row">${i}</th>
        <td>
          <input class="form-table__option-left" type="text" name="option-left-${i}" />
        </td>
        <td>
          <input class="form-table__option-right" type="text" name="option-right-${i}" />
        </td>
        <td>
          <input type="checkbox" name="title-${i}" value='1' />
        </td>
        <td>
          <input type="checkbox" name="content-${i}" value='1' />
        </td>
        <td>
          <input type="checkbox" name="content-${i}" value='1' />
        </td>
        <td class="form-table__delete"> <span title="delete row" class="dashicons dashicons-minus"></span> </td>
      </tr>
      `)

      this.validationEvents(); // allow to validate this row
      this.deleteRowTrigger(); // allow to delete this row
      this.setTableRows();

      if ( tableRows.length + 1  == ajax_object.max_table_rows) 
        this.addRowBtn.addClass('hidden');
    }

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

  // validation for a row
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
