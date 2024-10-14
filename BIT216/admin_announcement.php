<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Announcement</title>
  <link rel="stylesheet" href="css/admin_announcement.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Jua&display=swap">

</head>
<body>
  <div class="container">


    <?php
      include 'admin_nav.php';
    ?>

    <div class="content">
    <div class="announcement-container">
            <div class="admin-panel">
                <div class="add_wording">
                    <h3>Add Announcement</h3>
                </div>
                <form id="announcementForm">
                    <div class="input-group">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" placeholder="Enter title" required />
                    </div>
                    <div class="input-group">
                        <label for="image">Image</label>
                        <input type="file" id="image" name="image" accept="image/*" />
                    </div>
                    <div class="input-group">
                        <label for="content">Content</label>
                        <textarea id="content" name="content" placeholder="Enter announcement details" required></textarea>
                    </div>
                    <button type="submit">Add</button>
                </form>
            </div>

            <div class="announcement-list">
                <div class="all_anno">
                    <h1>All Annoucements</h3>
                </div>
                <div class="list-header">
                    <span>Name</span>
                    <select id="sortDropdown" onchange="sortAnnouncements()">
                        <option value="desc">Latest to Oldest</option>
                        <option value="asc">Oldest to Latest</option>
                    </select>

                </div>
                <ul id="announcementDisplay"></ul>
                <button id="showMoreBtn" onclick="showMore()">Show More</button>
            </div>
        </div>

    </div>
  </div>

  <div id="announcementModal" class="modal">
    <div class="modal-content">
      <span class="close-btn" onclick="closeModal()">&times;</span>
      <h2 id="modalTitle"></h2>
      <img id="modalImage" src="" alt="Announcement Image" style="display:none;">
      <p id="modalContent"></p>
    </div>
  </div>


  <script>
    let announcements = [
    { 
        title: "University 1", 
        content: "Join us for a university-wide event on October 15, 2024. Free snacks and fun activities for all attendees!",
        date: "2024-10-01", 
        image: null 
    },
    { 
        title: "New Library 2", 
        content: "Starting from September 28, the library will be open from 7 AM to 10 PM every day.",
        date: "2024-09-01", 
        image: null 
    },
    { 
        title: "Workshop on AI3", 
        content: "Attend a hands-on workshop on Artificial Intelligence and Machine Learning this Friday.",
        date: "2024-09-02", 
        image: null 
    },
    { 
        title: "Exam Schedule Released4", 
        content: "The final exam schedule has been posted. Check the university portal for details.The final exam schedule has been posted. Check the university portal for details.The final exam schedule has been posted. Check the university portal for details.The final exam schedule has been posted. Check the university portal for details.The final exam schedule has been posted. Check the university portal for details.",
        date: "2024-09-03", 
        image: null 
    },
    { 
        title: "Health and Safety Guidelines5", 
        content: "Please follow the updated health and safety guidelines during the flu season.",
        date: "2024-09-04", 
        image: null 
    },
    { 
        title: "Health and Safety Guidelines6", 
        content: "Please follow the updated health and safety guidelines during the flu season.",
        date: "2024-09-05", 
        image: null 
    },
    { 
        title: "Health and Safety Guidelines7", 
        content: "Please follow the updated health and safety guidelines during the flu season.",
        date: "2024-09-06", 
        image: null 
    },
    { 
        title: "Health and Safety Guidelines8", 
        content: "Please follow the updated health and safety guidelines during the flu season.",
        date: "2024-09-07", 
        image: null 
    },
    { 
        title: "Health and Safety Guidelines9", 
        content: "Please follow the updated health and safety guidelines during the flu season.",
        date: "2024-09-08", 
        image: null 
    },
    { 
        title: "Health and Safety Guidelines10", 
        content: "Please follow the updated health and safety guidelines during the flu season.",
        date: "2024-09-09", 
        image: null 
    },
    { 
        title: "Health and Safety Guidelines11", 
        content: "Please follow the updated health and safety guidelines during the flu season.",
        date: "2024-09-10", 
        image: null 
    }
];
let itemsToShow = 5;

function displayAnnouncements() {
      const announcementDisplay = document.getElementById("announcementDisplay");
      announcementDisplay.innerHTML = '';

      // Define the maximum length of content to display before truncation
      const maxLength = 220;

      const visibleAnnouncements = announcements.slice(0, itemsToShow);

      visibleAnnouncements.forEach((announcement, index) => {
        const li = document.createElement("li");

        // Check if the content exceeds the maxLength
        let truncatedContent = announcement.content;
        if (announcement.content.length > maxLength) {
          truncatedContent = announcement.content.substring(0, maxLength) + '......';
        }

        // Render the truncated content in the list item
        li.innerHTML = `<strong>${announcement.title}</strong><br/>${truncatedContent}<br/><em>${announcement.date}</em>`;
        li.style.cursor = 'pointer'; // Make the list item clickable
        li.onclick = () => openModal(index); // Add click event to show the modal

        announcementDisplay.appendChild(li);
      });

      // Check if there are more announcements to show
      if (announcements.length > itemsToShow) {
        document.getElementById("showMoreBtn").style.display = "block";
      } else {
        document.getElementById("showMoreBtn").style.display = "none";
      }
    }

    function openModal(index) {
      const modal = document.getElementById("announcementModal");
      const selectedAnnouncement = announcements[index];

      document.getElementById("modalTitle").textContent = selectedAnnouncement.title;
      document.getElementById("modalContent").textContent = selectedAnnouncement.content;

      if (selectedAnnouncement.image) {
        const modalImage = document.getElementById("modalImage");
        modalImage.src = selectedAnnouncement.image;
        modalImage.style.display = "block"; // Show the image
      } else {
        document.getElementById("modalImage").style.display = "none"; // Hide the image if not available
      }

      modal.style.display = "block"; // Show the modal
    }

    function closeModal() {
      document.getElementById("announcementModal").style.display = "none"; // Hide the modal
    }

    window.onclick = function(event) {
      const modal = document.getElementById("announcementModal");
      if (event.target === modal) {
        modal.style.display = "none"; // Close the modal if the user clicks outside of it
      }
    }

    function showMore() {
      itemsToShow += 5;
      displayAnnouncements();
    }

function sortAnnouncements() {
        const sortOrder = document.getElementById("sortDropdown").value;

        announcements.sort((a, b) => {
            const dateA = new Date(a.date);
            const dateB = new Date(b.date);

            if (sortOrder === 'asc') {
                return dateA - dateB;  // Sort by oldest first
            } else {
                return dateB - dateA;  // Sort by newest first
            }
        });

        displayAnnouncements();  // Re-render the list
    }

    // Initialize announcements by sorting and displaying the first set
    sortAnnouncements();
    displayAnnouncements();


  </script>
</body>
</html>
