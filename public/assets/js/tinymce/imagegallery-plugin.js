tinymce.PluginManager.add("imagegallery", function (editor, url) {
  // Register the API endpoint option
  editor.options.register("image_gallery_api_endpoint", {
    processor: "string",
    default: "",
  });

  const imagesPerPage = 20; // Number of images to load per page
  let currentPage = 1;
  let totalImages = 0;

  // Function to fetch images from the API
  function fetchImagesFromAPI(page) {
    const apiEndpoint = editor.options.get("image_gallery_api_endpoint");
    return fetch(`${apiEndpoint}?page=${page}&limit=${imagesPerPage}`)
      .then((response) => response.json())
      .then((data) => {
        totalImages = data.total; // Assuming the API returns total number of images
        return data.data;
      })
      .catch((error) => {
        console.error("Error fetching images:", error);
        return [];
      });
  }

  // Function to create the HTML for the image grid
  function createImageGrid(images) {
    return `
      <style>
        .image-gallery-modal .image-grid {
          display: flex;
          flex-wrap: wrap;
          gap: 10px;
          justify-content: space-around;
        }
        .image-gallery-modal .image-grid-item {
          flex: 1 1 calc((100% / 4) - 10px);
          box-sizing: border-box;
          cursor: pointer;
        }
        .image-gallery-modal .card {
          width: 100%;
          border: var(--mdb-border-width) solid var(--mdb-border-color);
        }
        .image-gallery-modal .card img {
          width: 100%;
          height: 150px;
          object-fit: cover;
        }
        .image-gallery-modal .card-body {
          padding: 10px;
        }
        .image-gallery-modal .card-title {
          margin-bottom: 5px;
          display: -webkit-box;
          -webkit-line-clamp: 2;
          -webkit-box-orient: vertical;
          overflow: hidden;
        }
        .image-gallery-modal .card-text {
          display: -webkit-box;
          -webkit-line-clamp: 2;
          -webkit-box-orient: vertical;
          overflow: hidden;
        }
      </style>
      <div class="image-gallery-modal">
        <div class="image-grid">
          ${images
            .map(
              (image) => `
            <div class="image-grid-item" data-uri="${image.uri}" data-judul="${image.judul}" data-alt="${image.alt}" data-deskripsi="${image.deskripsi}">
              <div class="card">
                <img src="${image.uri}" class="card-img-top" alt="${image.alt}">
                <div class="card-body">
                  <h5 class="card-title fw-bold">${image.judul}</h5>
                  <p class="card-text">${image.deskripsi}</p>
                </div>
              </div>
            </div>
          `
            )
            .join("")}
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px;">
          <label>
            <input type="checkbox" id="includeDescription" checked>
            Include Description
          </label>
        </div>
      </div>
    `;
  }

  // Function to open the image gallery modal
  function openImageGallery() {
    const modal = editor.windowManager.open({
      title: "Image Gallery",
      size: "large",
      body: {
        type: "panel",
        items: [
          {
            type: "htmlpanel",
            html: '<div class="loading">Loading images...</div>',
          },
        ],
      },
      buttons: [
        {
          text: "Close",
          type: "cancel",
          onclick: "close",
        },
      ],
    });

    // Fetch initial images
    fetchImagesFromAPI(currentPage).then((images) => {
      modal.redial({
        title: "Image Gallery",
        size: "large",
        body: {
          type: "panel",
          items: [
            {
              type: "htmlpanel",
              html: createImageGrid(images),
            },
          ],
        },
        buttons: [
          {
            text: "Close",
            type: "cancel",
            onclick: "close",
          },
        {
          type: 'menu', // button type
          name: 'imageGalleryMenuOptionsButton', // identifying name
          text: 'Options', // text for the button
          // icon: 'user', // will replace the text if configured
          enabled: true, // button is active when the dialog opens
          align: 'start', // align the button to the left of the dialog footer
          tooltip: 'This is "My" button.',
          items: [
            {
              name: 'dialogMenuButtonItemInsertWithDescription',
              type: 'togglemenuitem',
              text: 'Insert with description'
            },
            {
              name: 'dialogMenuButtonItemInsertWithoutDescription',
              type: 'togglemenuitem',
              text: 'Insert without description'
            }
          ]
        }
        ],
      });

      // Handle image selection
      document
        .querySelectorAll(".image-gallery-modal .image-grid-item")
        .forEach((item) => {
          item.addEventListener("click", () => {
            const imgData = item.dataset;
            const includeDescription = document.getElementById("includeDescription").checked;
            const descriptionText = includeDescription ? `<p>${imgData.deskripsi}</p>` : '';

            editor.insertContent(`
              <img src="${imgData.uri}" alt="${imgData.alt}" title="${imgData.judul}" />
              ${descriptionText}
            `);
            editor.windowManager.close();
          });
        });

      // Infinite scrolling for loading more images
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting && totalImages > currentPage * imagesPerPage) {
            currentPage++;
            fetchImagesFromAPI(currentPage).then(newImages => {
              const grid = document.querySelector('.image-grid');
              grid.innerHTML += createImageGrid(newImages); // Append new images

              // Re-setup image selection for newly added images
              newImages.forEach(image => {
                const item = document.querySelector(`.image-grid-item[data-uri="${image.uri}"]`);
                if (item) {
                  item.addEventListener("click", () => {
                    const imgData = item.dataset;
                    const includeDescription = document.getElementById("includeDescription").checked;
                    const descriptionText = includeDescription ? `<p>${imgData.deskripsi}</p>` : '';

                    editor.insertContent(`
                      <img src="${imgData.uri}" alt="${imgData.alt}" title="${imgData.judul}" />
                      ${descriptionText}
                    `);
                    editor.windowManager.close();
                  });
                }
              });
            });
            observer.unobserve(entry.target);
          }
        });
      });

      // Observe the last image in the grid for infinite scroll
      const lastImage = document.querySelector('.image-grid-item:last-child');
      if (lastImage) {
        observer.observe(lastImage);
      }
    });
  }

  // Register the button in the toolbar
  editor.ui.registry.addButton("imagegallery", {
    text: "Image Gallery",
    onAction: openImageGallery,
  });

  // Register the menu item in the context menu
  editor.ui.registry.addMenuItem("imagegallery", {
    text: "Image Gallery",
    onAction: openImageGallery,
  });

  // Add the menu item to the context menu
  editor.ui.registry.addContextMenu("imagegallery", {
    update: function (element) {
      return !element.closest("img") ? "imagegallery" : "";
    },
  });

  // Add the plugin button to the toolbar
  editor.on("init", function () {
    editor.ui.registry.addToggleButton("imagegallery", {
      icon: "image",
      tooltip: "Image Gallery",
      onAction: openImageGallery,
    });
  });
});
