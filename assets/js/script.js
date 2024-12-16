document.addEventListener("DOMContentLoaded", function () {
  const menuItems = document.querySelectorAll(".main-nav > li");

  menuItems.forEach((item) => {
    // Thêm sự kiện hover khi chuột di chuyển
    item.addEventListener("mouseenter", function () {
      const subMenu = item.querySelector(".sub-menu");
      if (subMenu) {
        subMenu.style.display = "block";
      }
    });

    item.addEventListener("mouseleave", function () {
      const subMenu = item.querySelector(".sub-menu");
      if (subMenu) {
        subMenu.style.display = "none";
      }
    });
  });
});

