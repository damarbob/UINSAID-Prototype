/**
 * Delete Image (Development version)
 * A plugin to clean up uploaded images after deleted from the editor.
 *
 * Written by Damar Syah Maulana
 * http://dsm.my.id
 */
tinymce.PluginManager.add("deleteimage", (editor, url) => {
  // Add to context menu
  editor.options.set(
    "contextmenu",
    editor.options.get("contextmenu") + " | deleteimage"
  );

  // Register an option
  editor.options.register("images_delete_url", {
    processor: "string",
    default: "/delete_image",
  });

  let observer; // Observer for image deletion purposes
  let deleteApiEndpoint = editor.options.get("images_delete_url"); // Default API endpoint
  let editorLastCopiedImageSrc = null; // Last copied image's source

  editor.on("init", () => {
    // Function to delete image using AJAX
    const deleteImage = (imageUrl) => {
      // Send AJAX request to delete image
      fetch(deleteApiEndpoint, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          image_url: imageUrl,
        }),
      })
        .then((response) => {
          if (response.ok) {
            return response.json();
          } else {
            throw new Error("Failed to delete image");
          }
        })
        .then((data) => {
          // Display an alert with the response message upon success
          console.log(data.message);
        })
        .catch((error) => {
          console.error("Error deleting image:", error);
        });
    };

    // Function to normalize image URLs by removing protocol and www subdomain
    const normalizeImageUrl = (imageUrl) => {
      // Convert URL to lowercase
      imageUrl = imageUrl.toLowerCase();
      // Remove protocol and www subdomain if present
      imageUrl = imageUrl.replace(/^(https?:\/\/)?(www\.)?/, "");
      return imageUrl;
    };

    // Function to handle image deletion
    const handleImageDeletion = (mutationList) => {
      mutationList.forEach((mutation) => {
        let removedNodes = mutation.removedNodes;

        if (mutation.type !== "childList") return;
        if (removedNodes.length === 0) return; // If no removed nodes, exit

        // If user is deleting all contents and not copying any images previously
        if (
          mutation.target === editor.getBody() &&
          mutation.previousSibling === null &&
          !editorLastCopiedImageSrc
        ) {
          // If user deletes the entire content, there will be only one element in removedNodes
          removedNodes[0].childNodes.forEach((node) => {
            if (node.nodeName === "IMG") {
              const imageUrl = node.currentSrc;
              deleteImage(imageUrl);
              console.log("Deleting image:" + imageUrl);
            }
          });
          return;
        }

        // Iterate through removedNodes and delete images from server if any
        removedNodes.forEach((node) => {
          if (node.nodeName === "IMG") {
            const imageUrl = node.currentSrc;
            if (imageUrl) {
              // Normalize the URL
              const normalizedUrl = normalizeImageUrl(imageUrl);
              // Check if there are any other occurrences of the same normalized image URL
              const allOccurrences = Array.from(
                editor.getBody().querySelectorAll(`img[src]`)
              ).filter((img) => {
                const imgSrc = normalizeImageUrl(img.currentSrc); // Normmalize URL by removing the http:// and www.
                return imgSrc === normalizedUrl;
              });
              if (allOccurrences.length === 0) {
                // If there is only one occurrence (the one being deleted), delete the image
                deleteImage(imageUrl);
              }
            }
          }
        });
      });
    };

    // Observe changes to the editor's content
    observer = new MutationObserver(handleImageDeletion);
    const targetNode = editor.getBody().parentNode;
    observer.observe(targetNode, {
      subtree: true,
      childList: true,
    });

    // Add menu item to delete image
    editor.ui.registry.addMenuItem("deleteimage", {
      icon: "cancel",
      text: "Delete Image",
      onAction: () => {
        const selectedNode = editor.selection.getNode();
        if (selectedNode.nodeName === "IMG") {
          const imageUrl = selectedNode.getAttribute("src");
          if (imageUrl) {
            // Delete the image
            deleteImage(imageUrl);
          }
        }
      },
    });

    // Add context menu item to delete image
    editor.ui.registry.addContextMenu("deleteimage", {
      update: (element) => {
        return element.nodeName === "IMG" ? "deleteimage" : "";
      },
    });
  });

  // Add an event listener for the copy event
  editor.on("copy", function (e) {
    let nodeName = e.target.nodeName;
    let imageSrc = e.target.currentSrc;

    editorLastCopiedImageSrc = nodeName === "IMG" ? imageSrc : null;
  });

  // When the editor is removed
  editor.on("remove", () => {
    // Disconnect observer when the editor is removed
    if (observer) {
      observer.disconnect();
    }
  });
});
