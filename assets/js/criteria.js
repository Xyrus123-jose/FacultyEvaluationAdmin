const container = document.getElementById('criteriaContainer');
const form = document.getElementById('criteriaForm');
const questionInput = document.getElementById('criteria_question');
const scoreInput = document.getElementById('max_score');
const categoryInput = document.getElementById('evaluation_category_id');
const clearAllBtn = document.getElementById('clearAllBtn');

// Fetch criteria from database
const getData = async () => {
  try {
    const response = await fetch('GetCriteria.php');
    const data = await response.json();
    return data;
  } catch (error) {
    console.error('Failed to fetch criteria:', error);
    return [];
  }
};

// Render criteria
const renderData = (data) => {
  container.innerHTML = '';

  if (!data.length) {
    container.innerHTML = `
      <div class="empty-state text-center p-3">
        <i class="fas fa-clipboard-list fa-2x mb-2"></i>
        <h5>No evaluation criteria yet</h5>
        <p>Add your first evaluation question using the form.</p>
      </div>
    `;
    return;
  }

  const grouped = data.reduce((acc, item) => {
    acc[item.evaluation_category] = acc[item.evaluation_category] || [];
    acc[item.evaluation_category].push(item);
    return acc;
  }, {});

  for (const [cat, items] of Object.entries(grouped)) {
    const categoryCard = document.createElement('div');
    categoryCard.className = 'category-card mb-3 border rounded p-2';

    const header = document.createElement('div');
    header.className = 'category-header d-flex justify-content-between align-items-center mb-2';
    header.innerHTML = `<strong>${cat}</strong> <span>${items.length} criteria</span>`;
    categoryCard.appendChild(header);

    const body = document.createElement('div');
    body.className = 'category-body';

    items.forEach((item, index) => {
      const questionCard = document.createElement('div');
      questionCard.className = 'question-card border rounded p-2 mb-2 d-flex justify-content-between align-items-center';
        const numberFontSize = Math.max(12, 16 - item.criteria_question.length / 20); // smaller divisor for subtle change
        const textFontSize = Math.max(12, 18 - item.criteria_question.length / 10);

        questionCard.innerHTML = `
        <div class="question-content d-flex align-items-center">
            <span class="question-number me-3" style="font-size: ${numberFontSize}px;">
                ${index + 1}.
            </span>
            <span class="question-text" style="font-size: ${textFontSize}px;">
                ${item.criteria_question}
            </span>
        </div>
        <div class="rating-radios d-flex gap-1 me-3">
            ${generateRadios(item.max_score)}
        </div>
        <div class="action-btns">
        <button class="btn p-1" onclick='openEditModal(${JSON.stringify(item)})' style="background: none; border: none; color: #0d6efd;">
         <i class="fas fa-edit"></i>
        </button>
        <button class="btn p-1" onclick="deleteItem(${item.criteria_id})" style="background: none; border: none; color: #dc3545;">
            <i class="fas fa-times"></i>
        </button>
        </div>
        `;

      body.appendChild(questionCard);
    });

    categoryCard.appendChild(body);
    container.appendChild(categoryCard);
  }
};

// Generate radio buttons for rating
const generateRadios = (max) => {
  return Array.from({ length: max }, (_, i) => {
    const val = i + 1;
    return `<div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="score-${val}" value="${val}">
              <label class="form-check-label">${val}</label>
            </div>`;
  }).join('');
};

// Add new criteria
form.addEventListener('submit', async (e) => {
  e.preventDefault();
  const formData = new FormData(form);

  try {
    const response = await fetch(form.action, { method: 'POST', body: formData });
    const data = await response.json();

    if (data.status === 'success') {
      Swal.fire('Added!', data.message, 'success').then(async () => {
        form.reset();
        const updatedData = await getData();
        renderData(updatedData);
      });
    } else {
      Swal.fire('Error!', data.message, 'error');
    }
  } catch (error) {
    console.error(error);
    Swal.fire('Error!', 'Something went wrong.', 'error');
  }
});

// Delete criteria
window.deleteItem = async (criteriaId) => {
  if (!confirm('Are you sure you want to delete this criteria?')) return;

  const formData = new FormData();
  formData.append('criteria_id', criteriaId);

  try {
    const response = await fetch('DeleteCriteria.php', { method: 'POST', body: formData });
    const data = await response.json();

    if (data.status === 'success') {
      Swal.fire('Deleted!', data.message, 'success').then(async () => {
        const updatedData = await getData();
        renderData(updatedData);
      });
    } else {
      Swal.fire('Error!', data.message, 'error');
    }
  } catch (error) {
    console.error(error);
    Swal.fire('Error!', 'Something went wrong.', 'error');
  }
};

// Initial load
window.onload = async () => {
  const data = await getData();
  renderData(data);
};

function openEditModal(criteria) {
    document.getElementById('edit_criteria_id').value = criteria.criteria_id;
    document.getElementById('edit_criteria_question').value = criteria.criteria_question;
    document.getElementById('edit_max_score').value = criteria.max_score;
    document.getElementById('edit_evaluation_category_id').value = criteria.evaluation_category_id;
    document.getElementById('edit_evaluation_type').value = criteria.evaluation_type;
    document.getElementById('edit_use_state').value = criteria.use_state;

    var editModal = new bootstrap.Modal(document.getElementById('editCriteriaModal'));
    editModal.show();
}
