document.addEventListener('DOMContentLoaded', () => {
  const nav = document.querySelector('.nav-links');
  const menu = document.querySelector('.menu-toggle');
  menu?.addEventListener('click', () => {
    nav.classList.toggle('open');
    menu.setAttribute('aria-expanded', nav.classList.contains('open'));
  });
  document.querySelectorAll('.toggle-password').forEach(button => button.addEventListener('click', () => {
    const input = button.previousElementSibling;
    input.type = input.type === 'password' ? 'text' : 'password';
    button.textContent = input.type === 'password' ? '👁' : '●';
    button.setAttribute('aria-label', input.type === 'password' ? 'Показать пароль' : 'Скрыть пароль');
    button.setAttribute('aria-pressed', input.type === 'password' ? 'false' : 'true');
  }));
  const main = document.querySelector('#main-photo');
  document.querySelectorAll('.thumb').forEach(thumb => thumb.addEventListener('click', () => {
    main.src = thumb.dataset.image;
    document.querySelectorAll('.thumb').forEach(item => item.classList.remove('selected'));
    thumb.classList.add('selected');
  }));
});
