$(document).ready(function () {
  const addProductButton = $('.add-Product')
  var body = $('body')
  populateProductTable()

  // Function to fetch data and populate the table
  function populateProductTable () {
    const productTableBody = $('#productTableBody tbody')
    productTableBody.empty()

    $.ajax({
      url: 'get-product.php', // Replace with the URL to fetch data from the server
      type: 'GET',
      dataType: 'json',
      success: function (data) {
        // Clear existing table rows
        productTableBody.empty()
        // Loop through the data and create table rows
        $.each(data, function (index, item, data) {
          var row = $('<tr>').appendTo(productTableBody)

          // Create an image cell for the item's image
          var imgCell = $('<td class="w-32 p-4">').appendTo(row)
          $('<img class="w-32 h-20 rounded items-center">')
            .attr('src', 'uploaded/' + item.pro_img)
            .appendTo(imgCell)

          // Create and append table cells for each item property
          // $('<td>').text(item.id).appendTo(row)
          $(
            '<th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">'
          )
            .text(item.pro_name)
            .appendTo(row)
          $('<td>').text(item.pro_qty).appendTo(row)
          $('<td>').text(item.pro_des).appendTo(row)
          $('<td>').text(item.pro_category).appendTo(row)
          $('<td>')
            .text('$' + item.pro_price + ',00')
            .appendTo(row)

          // Create a cell for action buttons
          var actionCell = $('<td>').appendTo(row)
          $(
            '<button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" id="btnDeleteItem"></button>'
          )
            .text('Delete')
            .data('id', item.id)
            .appendTo(actionCell)
          $(
            '<button type="button" class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900" id="btnEditItem"></button>'
          )
            .text('Edit')
            .appendTo(actionCell)

          $('<td>').text(item.pro_date).appendTo(row)

          // Create a cell for the checkbox
          $('<td class="w-4 p-4">')
            .appendTo('<div class="flex items-center"></div>')
            .append(
              $(
                '<input type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">'
              )
            )
            .appendTo(row)
        })
      },
      error: function (xhr, status, error) {
        console.error('Error fetching data:', xhr)
      }
    })
  }

  addProductButton.on('click', function (e) {
    e.preventDefault()

    var form = $('#productForm')
    var formData = new FormData(form[0])

    $.ajax({
      type: 'POST',
      url: 'add-product.php',
      data: formData,
      contentType: false,
      cache: false,
      processData: false,
      success: function (response) {
        // form[0].reset()
        populateProductTable()
      },
      error: function (xhr, status, error) {
        // display error message
        alert('Error')
      }
    })
  })
  body.on('click', '#btnDeleteItem', function (e) {
    e.preventDefault()
    const id = $(this).data('id')
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then(result => {
      if (result.isConfirmed) {
        $.ajax({
          url: 'delete-product.php',
          method: 'DELETE',
          success: function () {
            populateProductTable().reset()
            form.fadein()
          },
          error: function (xhr) {
            alert(xhr)
          }
        })
      }
    })
  })

  btnEditItem.on('click', function () {
    alert('edit')
  })
})
