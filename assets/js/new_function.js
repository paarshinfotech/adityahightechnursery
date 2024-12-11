function performDelete(tableName, page = 1, checkboxSelector, ajaxCallback) {
    if (confirm('विक्री हटवा..?')) {
        // Get checked checkbox values
        var checkedValues = $(checkboxSelector + ':checked').map(function() {
            return this.value;
        }).get();

        // Perform AJAX call
        $.ajax({
            type: 'POST',
            url: 'ajax_delete_checked_item', // Replace with your server-side script
            data: {
                checkboxValues: checkedValues,
                tableName: tableName
            }
        }).done(function(data) {
            // console.log(data); // <-- Corrected from response to data
            alert(data);
            ajaxCallback(page);
        });
    }
}



function initializeDataTable(exportClass, DataTableId) {
    // Clear the export container
    $('.' + exportClass).empty();

    // Initialize DataTable
    var cusListTbl = $(DataTableId).DataTable({
        dom: 'Bftip', // Buttons, search, and pagination, excluding information
        order: [
            [1, 'asc'] // Set the default order based on the second column (index 1) in ascending order
        ],
        buttons: [{
            extend: 'collection',
            text: 'Export',
            className: 'btn-sm btn-outline-dark me-2',
            buttons: [
                'copy',
                'excel',
                'csv',
                'print'
            ]
        }],
        searching: false, // Disable search bar
        paging: false, // Disable pagination
        info: false // Disable information about the number of entries
    });

    // Move the buttons container to the specified export container
    cusListTbl.buttons().container().prependTo('.' + exportClass);
}

function unselectOption(selectIds) {
    selectIds.forEach(function(selectId) {
        $('#' + selectId).prop('selectedIndex', 0);
    });
}

function checkAll(masterCheckbox, multicheckitem) {
    // //console.log("Hello")
    var checkboxes = $(masterCheckbox).closest('table').find('.' + multicheckitem);
    checkboxes.prop('checked', masterCheckbox.checked);
}

const loader = `
  <style>
    .loader {
      font-weight: bold;
      font-family: sans-serif;
      font-size: 30px;
      animation: l1 1s linear infinite alternate;
    }
    .loader:before {
      content: "Loading...";
    }
    @keyframes l1 {
      to {
        opacity: 0;
      }
    }
  </style>
  <div style="width: 100%; height: 500px; display: flex; align-items: center; justify-content: center;">
    <div class="loader"></div>
  </div>
`;