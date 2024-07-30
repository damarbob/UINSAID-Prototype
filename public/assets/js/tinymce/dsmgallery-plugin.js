tinymce.PluginManager.add("dsmgallery", function (editor, url) {
  const apiEndpoint = editor.getParam("dsmgallery_api_endpoint", "");

  // Function to fetch images from API
  const fetchImages = (endpoint, page = 1, perPage = 9, search = "") => {
    return fetch(
      `${endpoint}?page=${page}&per_page=${perPage}&search=${encodeURIComponent(
        search
      )}`
    )
      .then((response) => response.json())
      .then((data) => {
        return data.data; // Extract the array of images
      })
      .catch((error) => {
        console.error("Error fetching images:", error);
      });
  };

  // Function to open the custom dialog
  const openDialog = () => {
    let currentPage = 1;
    const perPage = 9;
    let searchQuery = "";

    const dialogConfig = {
      title: "Insert Image from Gallery",
      size: "large",
      body: {
        type: "panel",
        items: [
          {
            type: "input", // Change from 'textbox' to 'input'
            name: "search",
            label: "Search",
          },
          {
            type: "button",
            text: "Search",
            name: "searchButton",
          },
          {
            type: "checkbox",
            name: "insertDescription",
            label: "Insert with description",
          },
          {
            type: "htmlpanel",
            html: `
                            <style>
                                .image-grid-item.selected {
                                    border: 2px solid #0073aa;
                                    background-color: #f0f0f0;
                                }
                                #loading-message {
                                    margin-top: 2rem;
                                    margin-bottom: 2rem;
                                    text-align: center;
                                    font-weight: bold;
                                }
                            </style>
                            <div id="image-grid" style="display: flex; flex-wrap: wrap; gap: 10px;"></div>
                        `,
          },
          {
            type: "htmlpanel",
            html: `
                            <div id="loading-message">Loading...</div>
                        `,
          },
        ],
      },
      buttons: [
        {
          type: "custom",
          text: "Previous",
          name: "prev",
        },
        {
          type: "custom",
          text: "Next",
          name: "next",
        },
        {
          type: "cancel",
          text: "Close",
        },
        {
          type: "submit",
          text: "Insert",
          primary: true,
          name: "insert",
        },
      ],
      initialData: {},
      onSubmit: (api) => {
        const data = api.getData();
        const selectedImage = document.querySelector(
          ".image-grid-item.selected"
        );

        if (selectedImage) {
          const img = selectedImage.dataset;
          let html = `<img src="${img.uri}" alt="${img.alt}" title="${img.title}" />`;
          if (data.insertDescription && img.deskripsi) {
            html += `<p>${img.deskripsi}</p>`;
          }
          editor.insertContent(html);
        }
        api.close();
      },
      onAction: (api, details) => {
        if (details.name === "prev" && currentPage > 1) {
          currentPage--;
          loadImages(api);
        } else if (details.name === "next") {
          currentPage++;
          loadImages(api);
        } else if (details.name === "searchButton") {
          const data = api.getData();
          searchQuery = data.search;
          currentPage = 1; // Reset to first page
          loadImages(api);
        }
      },
    };

    const dialogApi = editor.windowManager.open(dialogConfig);

    const loadImages = (api) => {
      const loadingMessage = document.getElementById("loading-message");
      const imageGrid = document.getElementById("image-grid");

      loadingMessage.style.display = "block"; // Show loading message
      imageGrid.style.display = "none"; // Hide image grid

      fetchImages(apiEndpoint, currentPage, perPage, searchQuery).then(
        (images) => {
          loadingMessage.style.display = "none"; // Hide loading message
          imageGrid.style.display = "flex"; // Show image grid
          renderImages(images);
        }
      );
    };

    const renderImages = (images) => {
      const imageGrid = document.getElementById("image-grid");
      imageGrid.innerHTML = images
        .map(
          (image) => `
                <div class="image-grid-item" data-uri="${
                  image.uri
                }" data-title="${image.judul}" data-alt="${
            image.alt
          }" data-deskripsi="${
            image.deskripsi || ""
          }" style="cursor: pointer; border: 1px solid #ccc; padding: 5px;">
                    <img src="${image.uri}" alt="${image.alt}" title="${
            image.judul
          }" style="width: 128px; height: 128px; object-fit: cover;" />
                </div>
            `
        )
        .join("");

      document.querySelectorAll(".image-grid-item").forEach((item) => {
        item.addEventListener("click", () => {
          document
            .querySelectorAll(".image-grid-item")
            .forEach((i) => i.classList.remove("selected"));
          item.classList.add("selected");
        });
      });
    };

    loadImages(dialogApi); // Load images when the dialog opens
  };

  // Add the button to the toolbar
  editor.ui.registry.addButton("dsmgallery", {
    text: "Gallery",
    onAction: openDialog,
  });

  return {
    getMetadata: () => ({
      name: "DSM Gallery",
      url: "#",
    }),
  };
});
