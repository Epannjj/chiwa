<?php $title = 'Pesan'; require 'includes/header.php'; require 'includes/sections.php';
page_hero('Form Detail Order', 'Isi detail pesanan Anda, kami akan memprosesnya.'); section_form_order(); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
  var form = document.getElementById('orderForm');
  if (!form) return;


  var namaInput = form.querySelector('[name="domain_nama"]');
  var extSelect = form.querySelector('[name="domain_ekstensi"]');
  var preview = document.getElementById('domainPreview');

  function updatePreview() {
    if (!preview) return;
    var nama = (namaInput.value || '').trim().toLowerCase().replace(/\s+/g, '');
    var ext = extSelect.value || '.com';
    preview.textContent = (nama || 'namadomain') + ext;
  }
  if (namaInput && extSelect) {
    namaInput.addEventListener('input', updatePreview);
    extSelect.addEventListener('change', updatePreview);
    updatePreview();
  }


  form.addEventListener('submit', function (e) {
    e.preventDefault();

    function val(n) {
      var el = form.querySelector('[name="' + n + '"]');
      return el ? el.value.trim() : '';
    }

    var required = ['nama', 'bisnis', 'domain_nama', 'template', 'deskripsi', 'wa'];
    for (var i = 0; i < required.length; i++) {
      if (!val(required[i])) {
        alert('Mohon isi field: ' + required[i].replace('_', ' '));
        return;
      }
    }

    var domainFull = val('domain_nama').toLowerCase().replace(/\s+/g, '') + val('domain_ekstensi');

    var msg =
'DETAIL ORDER\n' +
'* Nama Pemesan: ' + val('nama') + '\n' +
'* Nama Bisnis: ' + val('bisnis') + '\n' +
'* Domain: ' + domainFull + '\n' +
'* Template: ' + val('template') + '\n' +
'* Slogan: ' + val('slogan') + '\n' +
'* Deskripsi: ' + val('deskripsi') + '\n' +
'* Logo: ' + val('logo') + '\n' +
'* WhatsApp: ' + val('wa') + '\n\n' +
'Data sudah tersimpan di sistem. Mohon dibantu prosesnya. Terima kasih!';

    var wa = form.getAttribute('data-wa');
    var url = 'https://wa.me/' + wa + '?text=' + encodeURIComponent(msg);

    var win = window.open(url, '_blank');
    if (!win || win.closed || typeof win.closed === 'undefined') {
      window.location.href = url;
    }

    setTimeout(function () { form.reset(); updatePreview(); }, 1000);
  });
});
</script>
<?php require 'includes/footer.php'; ?>