// Select all checkboxes and the dashboard elements
const topics = document.querySelectorAll('.topic');
const completed = document.getElementById('completed');
const total = document.getElementById('total');

// Initialize total number of topics
total.textContent = topics.length;

// Function to save progress in localStorage
function saveProgress() {
    const progress = [];
    topics.forEach((topic, index) => {
        progress[index] = topic.checked;
    });
    localStorage.setItem('phpRoadmapProgress', JSON.stringify(progress));
}

// Function to load progress from localStorage
function loadProgress() {
    const savedProgress = JSON.parse(localStorage.getItem('phpRoadmapProgress'));
    if (savedProgress !== null) {
        topics.forEach((topic, index) => {
            topic.checked = savedProgress[index];
        });
    }
}

// Function to update the completed count
function updateProgress() {
    const checkedCount = document.querySelectorAll('.topic:checked').length;
    completed.textContent = checkedCount;
    saveProgress();  // Save progress each time a checkbox is checked/unchecked
}

// Attach event listeners to each checkbox
topics.forEach(topic => {
    topic.addEventListener('change', updateProgress);
});

// Load progress when the page is loaded
window.addEventListener('load', () => {
    loadProgress();
    updateProgress();
});
