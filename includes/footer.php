</main>
<section class="cta"><div class="container">
  <h2>Siap Punya Website Profesional?</h2><p>Konsultasikan kebutuhan website Anda secara gratis sekarang.</p>
  <a class="btn btn-light" href="https://wa.me/<?= e($settings['whatsapp']) ?>" target="_blank">Chat WhatsApp</a>
</div></section>
<footer class="footer"><div class="container grid-3">
  <div><h3><?= e($settings['nama_situs']) ?></h3><p><?= e($settings['tagline']) ?></p></div>
  <div><h4>Menu</h4><?php foreach($nav as $k=>$v): ?><a href="<?= $k ?>.php"><?= $v ?></a><?php endforeach; ?></div>
  <div><h4>Kontak</h4><p><?= e($settings['alamat']) ?><br><?= e($settings['telepon']) ?><br><?= e($settings['email']) ?></p>
  <p><a href="<?= e($settings['instagram']) ?>">Instagram</a> · <a href="<?= e($settings['facebook']) ?>">Facebook</a></p></div>
</div><div class="container copy"><?= e($settings['footer']) ?></div></footer>
<a class="wa-float" href="https://wa.me/<?= e($settings['whatsapp']) ?>" target="_blank">💬</a>
<script src="assets/app.js"></script>
</body></html>
