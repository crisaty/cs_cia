$(function () {

    $('#tableEmpresas').DataTable({
        retrieve: true,
        paging: false,
        responsive: true,
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
      }
    });

});
