// Init Dragula
if (dragula) {
    const drg = dragula(Array.from(document.querySelectorAll('.js-drag-container')))
    drg.on('drop', (el, target, source, sibling) => {
      if (target.classList.contains('stage')) {
        const color = el.getAttribute('color')
        target.style.setProperty('--bg-color', color)
        
        if (sibling && sibling.tagName.toLowerCase() === 'book-element') {
          source.appendChild(sibling)
        }
      }
    })
  }
  
  // Custom Element Definition
  class BookElement extends HTMLElement {
    constructor() {
      super()
      this.template = document.getElementById('book-template')
      
      if (this.template) {
        this.attachShadow({ mode: "open" }).appendChild(this.template.content.cloneNode(true))
      }
    }
    
    static get observedAttributes() {
      return ['color'];
    }
    
    attributeChangedCallback(attrName, oldValue, newValue) {
      if (newValue !== oldValue) {
        this[attrName] = this.getAttribute(attrName);
        this.update();
      }
    }
    
    connectedCallback() {
      this.update();
    }
    
    update() {
      if (this.color) {
        this.style.setProperty('--cover-color', this.color)
      }
    }
  }
  
  if ('customElements' in window) {
      customElements.define('book-element', BookElement)
  }

  // Function to toggle dark mode
function toggleDarkMode() {
  document.body.classList.toggle('dark');
}

// Wait until the DOM is fully loaded
document.addEventListener('DOMContentLoaded', () => {
  // Create a button for toggling dark mode
  const darkModeToggle = document.createElement('button');
  darkModeToggle.innerHTML = '<i class="fas fa-moon"></i>'; // Using Font Awesome moon icon

  darkModeToggle.style.position = 'fixed';
  darkModeToggle.style.top = '1rem';
  darkModeToggle.style.right = '1rem';
  darkModeToggle.style.padding = '0.65rem';
  darkModeToggle.style.zIndex = 1000; // Ensure the button is above other elements
  darkModeToggle.addEventListener('click', toggleDarkMode);
  darkModeToggle.style.position = 'fixed';
  darkModeToggle.style.top = '1rem';
  darkModeToggle.style.right = '1rem';

  darkModeToggle.style.backgroundColor = '#000000';
  darkModeToggle.style.color = '#fff';
  darkModeToggle.style.border = 'none';
  darkModeToggle.style.borderRadius = '2px';
  darkModeToggle.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.1)';
  darkModeToggle.style.cursor = 'pointer';
  darkModeToggle.style.fontSize = '1rem';
  darkModeToggle.style.zIndex = 1000; // Ensure the button is above other elements
  darkModeToggle.style.transition = 'background-color 0.3s ease, transform 0.3s ease';


  // Add the button to the body
  document.body.appendChild(darkModeToggle);
});

