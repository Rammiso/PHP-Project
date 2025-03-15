// General utility to handle form submissions
function submitForm(formId, url, callback) {
  const form = document.getElementById(formId);
  form.addEventListener("submit", (e) => {
    e.preventDefault();
    const formData = new FormData(form);
    fetch(url, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.text())
      .then((data) => callback(data))
      .catch((error) => console.error("Error:", error));
  });
}

// Load requests dynamically based on role
function loadRequests(role, tableId, endpoint) {
  fetch(endpoint, {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `load_requests=true&role=${role}`,
  })
    .then((response) => response.json())
    .then((data) => {
      const table = document.getElementById(tableId);
      table.innerHTML =
        "<tr><th>ID</th><th>Destination</th><th>Amount</th><th>Status</th>" +
        (role === "manager" ? "<th>Actions</th>" : "") +
        "</tr>";
      data.forEach((req) => {
        let row = `<tr>
                <td>${req.id}</td>
                <td>${req.destination}</td>
                <td>$${req.amount}</td>
                <td>${req.status}</td>`;
        if (role === "manager" && req.status === "pending") {
          row += `<td>
                    <button onclick="updateStatus(${req.id}, 'approve')">Approve</button>
                    <button class="reject" onclick="updateStatus(${req.id}, 'reject')">Reject</button>
                </td>`;
        } else if (role === "manager") {
          row += "<td></td>";
        }
        row += "</tr>";
        table.innerHTML += row;
      });
    });
}

// Update request status (for managers)
function updateStatus(requestId, action) {
  fetch("/backend/request_controller.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `request_id=${requestId}&${action}=true`,
  })
    .then((response) => response.text())
    .then((data) => {
      alert(data);
      loadRequests(
        "manager",
        "manager_requests",
        "/backend/request_controller.php"
      );
    });
}

// Generate finance report
function generateReport() {
  const start = document.getElementById("report_start").value;
  const end = document.getElementById("report_end").value;
  fetch("/backend/report.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `generate_report=true&start_date=${start}&end_date=${end}`,
  })
    .then((response) => response.json())
    .then((data) => {
      const table = document.getElementById("report_table");
      table.innerHTML =
        "<tr><th>ID</th><th>User ID</th><th>Amount</th><th>Status</th></tr>";
      data.forEach((req) => {
        table.innerHTML += `<tr>
                <td>${req.id}</td>
                <td>${req.user_id}</td>
                <td>$${req.amount}</td>
                <td>${req.status}</td>
            </tr>`;
      });
    });
}
