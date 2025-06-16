const ctx = document.getElementById('enrollmentChart');
if (ctx) {
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
      datasets: [{
        label: 'New Enrollments',
        data: [20, 25, 30, 22, 35, 28],
        backgroundColor: 'rgba(95, 230, 185, 0.92)'
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true }
      }
    }
  });
}

 // Set current year 
  document.getElementById("copyright-year").textContent = new Date().getFullYear();



  