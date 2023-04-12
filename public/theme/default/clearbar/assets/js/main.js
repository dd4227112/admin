//atempty to use swal button instead  of default alert
function deleteRecord(uri, confirm) {
    Swal.fire({
      title: 'Are you sure?',
      text: confirm,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = uri;
      }
    });
  }

  