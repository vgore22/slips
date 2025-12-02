// script.js (client side)
document.addEventListener('DOMContentLoaded', function(){
  // PDF viewer
  document.querySelectorAll('.viewPdf').forEach(btn=>{
    btn.addEventListener('click', function(){
      const file = this.dataset.file;
      const modal = document.getElementById('pdfModal');
      const frame = document.getElementById('pdfFrame');
      frame.src = 'pdfs/' + file;
      modal.style.display = 'block';
    });
  });
  const closeModal = document.getElementById('closeModal');
  if (closeModal) closeModal.addEventListener('click', ()=> {
    document.getElementById('pdfFrame').src = '';
    document.getElementById('pdfModal').style.display = 'none';
  });

  // Start test
  let timerInterval = null;
  document.querySelectorAll('.startTest').forEach(btn=>{
    btn.addEventListener('click', function(){
      const testId = this.dataset.test;
      const duration = parseInt(this.dataset.duration, 10); // minutes
      startTest(testId, duration);
    });
  });

  async function startTest(testId, durationMinutes) {
    const resp = await fetch('get_questions.php?test_id=' + testId);
    const questions = await resp.json();
    document.getElementById('testTitle').textContent = 'Test';
    document.getElementById('questionsWrap').innerHTML = '';
    questions.forEach((q, idx) => {
      const html = `
        <div class="card">
          <p><strong>Q${idx+1}.</strong> ${escapeHtml(q.question)}</p>
          <label><input type="radio" name="q_${q.id}" value="a"> ${escapeHtml(q.opt_a)}</label>
          <label><input type="radio" name="q_${q.id}" value="b"> ${escapeHtml(q.opt_b)}</label>
          <label><input type="radio" name="q_${q.id}" value="c"> ${escapeHtml(q.opt_c)}</label>
          <label><input type="radio" name="q_${q.id}" value="d"> ${escapeHtml(q.opt_d)}</label>
        </div>`;
      document.getElementById('questionsWrap').insertAdjacentHTML('beforeend', html);
    });
    document.getElementById('testArea').style.display = 'block';
    // timer
    let timeLeft = durationMinutes * 60;
    document.getElementById('timeLeft').textContent = formatTime(timeLeft);
    const startTime = Date.now();
    if (timerInterval) clearInterval(timerInterval);
    timerInterval = setInterval(()=> {
      timeLeft--;
      document.getElementById('timeLeft').textContent = formatTime(timeLeft);
      if (timeLeft <= 0) {
        clearInterval(timerInterval);
        submitTest(testId, Math.round((Date.now()-startTime)/1000));
      }
    }, 1000);

    document.getElementById('submitTest').onclick = function(){
      clearInterval(timerInterval);
      submitTest(testId, Math.round((Date.now()-startTime)/1000));
    };
  }

  function formatTime(s) {
    const m = Math.floor(s/60);
    const sec = s % 60;
    return `${m}:${sec.toString().padStart(2,'0')}`;
  }

  function escapeHtml(s) {
    if(!s) return '';
    return s.replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;');
  }

  async function submitTest(testId, timeTakenSeconds) {
    const inputs = document.querySelectorAll('[name^="q_"]');
    const answers = {};
    // build map by question id
    const qnames = new Set();
    inputs.forEach(i=> qnames.add(i.name));
    qnames.forEach(name=>{
      const qid = name.split('_')[1];
      const sel = document.querySelector(`input[name="${name}"]:checked`);
      answers[qid] = sel ? sel.value : '';
    });

    const resp = await fetch('submit_test.php', {
      method: 'POST',
      headers: {'Content-Type':'application/json'},
      body: JSON.stringify({ test_id: testId, answers: answers, time_taken: timeTakenSeconds })
    });
    const data = await resp.json();
    alert(`Test submitted. Score: ${data.score}/${data.total}`);
    // redirect to dashboard to view full results
    window.location.href = 'dashboard.php';
  }
});
