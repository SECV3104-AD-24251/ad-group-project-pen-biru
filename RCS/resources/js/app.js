import './bootstrap';

// Custom JavaScript for Complaint Form
document.addEventListener('DOMContentLoaded', function () {
    const resourceTypeSelect = document.getElementById('resource_type');
    const detailsSelect = document.getElementById('details');
    const severityInput = document.getElementById('severity');

    resourceTypeSelect.addEventListener('change', function () {
        const selectedResource = this.value;

        // Clear previous details
        detailsSelect.innerHTML = '<option value="">Select Details</option>';
        severityInput.value = '';

        if (selectedResource) {
            // Fetch details based on resource type via AJAX
            fetch(`/resource/details?resource_type=${selectedResource}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(detail => {
                        const option = document.createElement('option');
                        option.value = detail.id;
                        option.textContent = detail.detail;
                        option.dataset.severity = detail.severity; // Store severity in dataset
                        detailsSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching details:', error));
        }
    });

    // Update severity when a detail is selected
    detailsSelect.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        severityInput.value = selectedOption.dataset.severity || '';
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const historyModal = document.getElementById('historyModal');
    const historyContainer = document.getElementById('history-container');

    historyModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Button that triggered the modal
        const complaintId = button.getAttribute('data-id'); // Retrieve the complaint ID

        // Display loading text
        historyContainer.innerHTML = '<p>Loading...</p>';

        // Fetch complaint history via AJAX
        fetch(`/complaints/${complaintId}/history`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch complaint history.');
                }
                return response.text(); // Expecting HTML content
            })
            .then(html => {
                // Inject the fetched HTML into the modal container
                historyContainer.innerHTML = html;
            })
            .catch(error => {
                console.error('Error fetching complaint history:', error);
                historyContainer.innerHTML = '<p class="text-danger">Failed to load complaint history.</p>';
            });
    });
});
