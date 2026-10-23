// Slider banner
const slides=document.querySelectorAll('.slide'),dots=document.querySelectorAll('.dots span');let cur=0;
function go(i){slides[cur]?.classList.remove('active');dots[cur]?.classList.remove('active');cur=i;slides[cur]?.classList.add('active');dots[cur]?.classList.add('active')}
dots.forEach((d,i)=>d.onclick=()=>go(i));if(slides.length>1)setInterval(()=>go((cur+1)%slides.length),5000);
// FAQ accordion
document.querySelectorAll('.faq-q').forEach(q=>q.onclick=()=>q.parentElement.classList.toggle('open'));
// Filter portofolio
document.querySelectorAll('.filters button').forEach(b=>b.onclick=()=>{
 document.querySelectorAll('.filters button').forEach(x=>x.classList.remove('active'));b.classList.add('active');
 document.querySelectorAll('.porto').forEach(c=>c.style.display=(b.dataset.filter==='all'||c.dataset.cat===b.dataset.filter)?'':'none')});
// Animasi muncul saat scroll
const io=new IntersectionObserver(es=>es.forEach(e=>{if(e.isIntersecting){e.target.classList.add('show');io.unobserve(e.target)}}),{threshold:.15});
document.querySelectorAll('.reveal').forEach(el=>io.observe(el));
// Counter statistik
const co=new IntersectionObserver(es=>es.forEach(e=>{if(!e.isIntersecting)return;const el=e.target,t=+el.dataset.count;let n=0;
 const s=setInterval(()=>{n+=Math.ceil(t/40);if(n>=t){n=t;clearInterval(s)}el.textContent=n},30);co.unobserve(el)}));
document.querySelectorAll('[data-count]').forEach(el=>co.observe(el));
