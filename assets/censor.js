
class Censorshipy {

  constructor() {
    this.inputTableRows = $('.form-table__rows-cnt');
    this.addRowBtn = $('.form-table__add');
    this.tableBody = $('.form-table tbody');
    this.events();
  }

  // events
  events() {
    $(document).ready(this.validateOnLoad.bind(this));
    this.addRowBtn.on('click', this.addRowBtnOnClick.bind(this))
    $('.form-table__option-left, .form-table__option-right').on('keyup', this.validateOnEvent.bind(this));
    $('input[type=checkbox]').on('click', this.validateOnEvent.bind(this) );
    $('.form-table__delete').on('click', this.deleteRow.bind(this));
  }

  // methods
  setTableRows() {
    var rows = $('.form-table tr:not(.form-table__top)'); // exclude table headers row
    this.inputTableRows.val(rows.length); 
  }

  deleteRow(e) {
    var currentRow = $(e.target).closest('tr'),
        checkboxesOptions = ['title-', 'content-', 'comments-'],
        checkboxes;
        
    currentRow.remove();

    // resign all rows options
    var raws = $('.form-table tr:not(.form-table__top)');
    raws.each(function(index) {
      index++;
      $(this).find('.form-table__number').text(index);
      $(this).find('.form-table__option-left').attr('name', 'option-left-' + index);
      $(this).find('.form-table__option-right').attr('name', 'option-right-' + index);
      
      checkboxes = $(this).find('input[type=checkbox]');
      
      checkboxes.each(function(i) {
        $(this).attr('name', checkboxesOptions[i] + index)
      })

    })

    this.setTableRows();
    this.addRowBtn.removeClass('hidden');

  }

  addRowBtnOnClick() {
    var tableRows = $('.form-table tr'),
        newRow,
        optionLeft,
        optionRight,
        checkboxes,
        deleteRowBtn;

    if (tableRows.length < CensorshipyData.max_table_rows ) {
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
      `);

      newRow = $(`.form-table tr:nth-child(${++i})`);

      // allow to validate and delete new row
      optionLeft = newRow.find('.form-table__option-left');
      optionRight = newRow.find('.form-table__option-right');
      checkboxes = newRow.find('input[type=checkbox]');
      deleteRowBtn = newRow.find('.form-table__delete');
      
      optionLeft.add(optionRight).on('keyup', this.validateOnEvent.bind(this)); 
      checkboxes.on('click', this.validateOnEvent.bind(this)); 
      deleteRowBtn.on('click', this.deleteRow.bind(this));
      
      this.setTableRows();

      if ( i >= CensorshipyData.max_table_rows)
        this.addRowBtn.addClass('hidden');
    }

  }

  // validate each row in our table on document load
  validateOnLoad() {
    var rows = $('.form-table tr:not(.form-table__top)'),
        that = this;

    rows.each(function() {
      that.validateTableRow($(this));
    })

  }

  // validate certain row on event
  validateOnEvent(e) {
    var target = $(e.target);
    this.validateTableRow(target.closest('tr'));
  }

  // validation for a row
  validateTableRow(row) {
    var checkboxes = row.find('input[type=checkbox]'),
        inputLeft = row.find('.form-table__option-left'),
        inputRight = row.find('.form-table__option-right'),
        checkInput = false;

    checkboxes.each(function() {
      if (this.checked) {
        checkInput = true;
        return false; // break from the loop
      }
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
