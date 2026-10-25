</main>
<section class="cta"><div class="container">
  <h2>Siap Punya Website Profesional?</h2><p>Konsultasikan kebutuhan website Anda secara gratis sekarang.</p>
  <a class="btn btn-light" href="order.php">Pesan Sekarang</a>
</div></section>
<footer class="footer"><div class="container grid-3">
  <div><h3><?= e($settings['nama_situs']) ?></h3><p><?= e($settings['tagline']) ?></p></div>
  <div><h4>Menu</h4><?php foreach($nav as $k=>$v): ?><a href="<?= $k ?>.php"><?= $v ?></a><?php endforeach; ?></div>
  <div><h4>Kontak</h4><p><?= e($settings['alamat']) ?><br><?= e($settings['telepon']) ?><br><?= e($settings['email']) ?></p>
  <p><a href="<?= e($settings['instagram']) ?>">Instagram</a> · <a href="<?= e($settings['facebook']) ?>">Facebook</a></p></div>
</div><div class="container copy"><?= e($settings['footer']) ?></div></footer>
<div class="wa-widget" id="waWidget">
  <div class="wa-popup" id="waPopup" hidden>
    <div class="wa-popup-head">
      <span class="wa-popup-title">Halo! 👋</span>
      <button class="wa-popup-close" id="waPopupClose" aria-label="Tutup">×</button>
    </div>
    <div class="wa-popup-body">Ada yang bisa kami bantu?</div>
    <div class="wa-popup-actions">
      <a class="wa-btn wa-btn-wa" href="https://wa.me/<?= e($settings['whatsapp']) ?>" target="_blank" rel="noopener">
        <span class="wa-btn-icon">💬</span>
        <span>
          <b>Chat WhatsApp</b>
          <small>Tanya dulu, gratis</small>
        </span>
      </a>
      <a class="wa-btn wa-btn-form" href="order.php">
        <span class="wa-btn-icon">📝</span>
        <span>
          <b>Isi Form Order</b>
          <small>Langsung pesan</small>
        </span>
      </a>
    </div>
  </div>
  <button class="wa-float" id="waFloat" type="button" aria-label="Hubungi kami">
    <span class="wa-icon-chat">💬</span>
    <span class="wa-icon-close">×</span>
  </button>
</div>
<style>
.wa-widget{position:fixed;right:22px;bottom:22px;z-index:60;font-family:'Plus Jakarta Sans',sans-serif}
.wa-widget *{box-sizing:border-box}
.wa-float{width:58px;height:58px;border-radius:50%;background:#25d366;border:0;color:#fff;font-size:1.6rem;display:grid;place-items:center;box-shadow:0 8px 20px rgba(0,0,0,.25);cursor:pointer;animation:pulse 2s infinite;transition:transform .2s,background .2s;position:relative}
.wa-float:hover{transform:scale(1.08)}
.wa-float .wa-icon-close{display:none;font-size:2rem;line-height:1;font-weight:400}
.wa-widget.open .wa-float{background:#e5484d;animation:none}
.wa-widget.open .wa-float .wa-icon-chat{display:none}
.wa-widget.open .wa-float .wa-icon-close{display:block}
@keyframes pulse{50%{transform:scale(1.08)}}
.wa-popup{position:absolute;right:0;bottom:74px;width:300px;max-width:calc(100vw - 44px);background:#fff;border-radius:16px;box-shadow:0 20px 50px -10px rgba(11,16,48,.35);overflow:hidden;transform-origin:bottom right;animation:waPop .2s ease-out}
@keyframes waPop{from{opacity:0;transform:scale(.85) translateY(10px)}to{opacity:1;transform:scale(1) translateY(0)}}
.wa-popup-head{background:linear-gradient(135deg,#0b1030,#1d2660);color:#fff;padding:14px 16px;display:flex;align-items:center;justify-content:space-between}
.wa-popup-title{font-weight:700;font-size:1rem}
.wa-popup-close{background:transparent;border:0;color:#fff;font-size:1.4rem;cursor:pointer;line-height:1;padding:0;width:26px;height:26px;border-radius:50%}
.wa-popup-close:hover{background:rgba(255,255,255,.15)}
.wa-popup-body{padding:14px 16px 4px;color:#3b4160;font-size:.9rem}
.wa-popup-actions{padding:10px 14px 14px;display:flex;flex-direction:column;gap:8px}
.wa-btn{display:flex;align-items:center;gap:12px;padding:10px 14px;border-radius:12px;text-decoration:none;color:inherit;border:1.5px solid #eef0f6;transition:.2s;background:#fff}
.wa-btn:hover{transform:translateY(-1px);box-shadow:0 6px 16px -8px rgba(0,0,0,.2)}
.wa-btn-icon{width:36px;height:36px;border-radius:10px;display:grid;place-items:center;font-size:1.2rem;flex:0 0 36px}
.wa-btn b{display:block;font-size:.9rem;color:#0b1030;line-height:1.2}
.wa-btn small{display:block;font-size:.75rem;color:#7a809a;line-height:1.2;margin-top:2px}
.wa-btn-wa .wa-btn-icon{background:#e6f9ee;color:#137a3e}
.wa-btn-form .wa-btn-icon{background:#e9ebff;color:#3341ff}
@media(max-width:480px){
  .wa-widget{right:14px;bottom:14px}
  .wa-float{width:54px;height:54px;font-size:1.4rem}
  .wa-popup{width:280px;bottom:68px}
}
</style>

<script>
(function () {
  var widget = document.getElementById('waWidget');
  var btn = document.getElementById('waFloat');
  var popup = document.getElementById('waPopup');
  var closeBtn = document.getElementById('waPopupClose');
  if (!widget || !btn || !popup) return;

  function openPopup() {
    popup.hidden = false;
    widget.classList.add('open');
    btn.setAttribute('aria-expanded', 'true');
  }
  function closePopup() {
    popup.hidden = true;
    widget.classList.remove('open');
    btn.setAttribute('aria-expanded', 'false');
  }
  function togglePopup() {
    if (popup.hidden) openPopup(); else closePopup();
  }

  btn.addEventListener('click', togglePopup);
  if (closeBtn) closeBtn.addEventListener('click', closePopup);


  document.addEventListener('click', function (e) {
    if (!widget.contains(e.target) && !popup.hidden) closePopup();
  });


  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && !popup.hidden) closePopup();
  });
})();
</script>

<script src="assets/app.js"></script>
</body></html>