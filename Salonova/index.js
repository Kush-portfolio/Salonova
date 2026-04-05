document.addEventListener("DOMContentLoaded", () => {
    console.log("✅ JavaScript initialized");

    // ===== Toggle Navbar in Mobile =====
    const navToggle = document.getElementById("navLinks2");
    window.toggleSecondNavbar = function () {
      if (navToggle) navToggle.classList.toggle("active");
    };

    // ===== Dropdown Menu Logic =====
    const dropdownParents = document.querySelectorAll(".dropdown-parent");
    dropdownParents.forEach(parent => {
      parent.addEventListener("click", function (e) {
        e.preventDefault();
        this.classList.toggle("active");
        dropdownParents.forEach(p => {
          if (p !== this) p.classList.remove("active");
        });
      });
    });

    const subParents = document.querySelectorAll(".sub-parent");
    subParents.forEach(parent => {
      parent.addEventListener("click", function (e) {
        e.stopPropagation();
        this.classList.toggle("active");
        subParents.forEach(sp => {
          if (sp !== this) sp.classList.remove("active");
        });
      });
    });

 // ===== Horizontal Scroll for Categories =====
window.scrollProducts = function (categoryId, direction) {
  const container = document.querySelector(`#${categoryId} .horizontal-scroll`);
  const scrollAmount = 250;
  if (container) {
    container.scrollBy({
      left: direction * scrollAmount,
      behavior: 'smooth'
    });
  }
};

    // ===== Search Functionality =====
    const searchInput = document.getElementById("searchInput");
    const searchResults = document.getElementById("searchResults");

    if (searchInput && searchResults) {
      searchInput.addEventListener("input", function () {
        const query = this.value.toLowerCase();
        if (query.length > 0) {
          searchResults.style.display = "block";
          searchResults.innerHTML = `<p>Searching for "${query}"...</p>`;
        } else {
          searchResults.style.display = "none";
        }
      });

      document.addEventListener("click", function (event) {
        if (!searchInput.contains(event.target) && !searchResults.contains(event.target)) {
          searchResults.style.display = "none";
        }
      });
    }

    // ===== Back to Top Button =====
    const backToTopBtn = document.getElementById("backToTop");
    if (backToTopBtn) {
      window.addEventListener("scroll", () => {
        if (window.scrollY > 300) {
          backToTopBtn.classList.add("show");
        } else {
          backToTopBtn.classList.remove("show");
        }
      });

      backToTopBtn.addEventListener("click", () => {
        window.scrollTo({ top: 0, behavior: "smooth" });
      });
    } else {
      console.warn("⚠️ backToTop button not found on this page.");
    }

    

    // ===== Add to Cart (Mock Logic) =====
    window.addToCart = function (name, price) {
      alert(`Added ${name} (₹${price}) to cart!`);
      console.log(`Cart: ${name} - ₹${price}`);
    };
  });