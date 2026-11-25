/* GeraSim — comportamento das telas (JavaScript puro, sem framework).
   Cada bloco só roda se a tela correspondente estiver na página. */
(function () {
  const $ = (s, el = document) => el.querySelector(s);
  const $$ = (s, el = document) => [...el.querySelectorAll(s)];
  const LETTERS = ['A', 'B', 'C', 'D', 'E'];

  /* ---------- Menu lateral no celular ---------- */
  $$('[data-nav-open]').forEach(b => b.addEventListener('click', () => document.body.classList.add('nav-open')));
  $$('[data-nav-close]').forEach(b => b.addEventListener('click', () => document.body.classList.remove('nav-open')));

  /* ---------- Filtros em pílula ---------- */
  $$('.gs-pills').forEach(g => g.addEventListener('click', e => {
    const b = e.target.closest('button'); if (!b) return;
    g.querySelectorAll('button').forEach(x => x.classList.toggle('active', x === b));
    // Detalhes da tentativa: filtra questões certas/erradas
    const list = $('#attempt-list');
    if (list && g.closest('section, main')?.contains(list)) {
      const f = b.textContent.startsWith('Erradas') ? 'wrong' : b.textContent.startsWith('Certas') ? 'right' : 'all';
      $$('[data-result]', list).forEach(c => { c.hidden = f !== 'all' && c.dataset.result !== f; });
    }
  }));

  /* ---------- Adicionar disciplina: "Outros" mostra campo livre ---------- */
  const discSel = $('#disc-select'), discWrap = $('#disc-other-wrap');
  if (discSel && discWrap) {
    const sync = () => { discWrap.hidden = discSel.value !== 'outros'; };
    discSel.addEventListener('change', sync); sync();
  }

  /* ---------- Upload: arrastar e soltar ---------- */
  const drop = $('#up-drop');
  if (drop) {
    ['dragenter', 'dragover'].forEach(ev => drop.addEventListener(ev, e => { e.preventDefault(); drop.classList.add('drag'); }));
    ['dragleave', 'drop'].forEach(ev => drop.addEventListener(ev, e => { e.preventDefault(); drop.classList.remove('drag'); }));
    drop.addEventListener('drop', e => { const input = $('#up-file'); if (input && e.dataTransfer?.files) input.files = e.dataTransfer.files; });
  }

  /* ---------- Tópicos extraídos: selecionar todos ---------- */
  const tpAll = $('#tp-all');
  if (tpAll) tpAll.addEventListener('change', () => $$('#tp-list input').forEach(i => { i.checked = tpAll.checked; }));

  /* ---------- Criar simulado: distribuição por tópico + reaproveitamento ----------
     Cada checkbox de tópico tem data-bank = questões já existentes no banco.
     Faltando questões, só a diferença vai para a IA (a regra real fica no backend). */
  const simTopicsBox = $('#sim-topics');
  if (simTopicsBox) {
    const distVals = { 'Triggers': 5, 'Estrutura de Dados': 3, 'Funções': 2 };
    const simTopics = () => $$('#sim-topics input:checked').map(i => ({ name: i.value, bank: +i.dataset.bank }));
    const renderDist = () => {
      const custom = $('#sim-custom').checked, box = $('#sim-dist');
      box.hidden = !custom;
      box.innerHTML = simTopics().map(t => {
        const id = 'dist-' + t.name.replace(/\W+/g, '-');
        return `<div class="d-flex align-items-center gap-3 p-2 px-3 rounded-4" style="background:#fafaff">
          <label class="flex-grow-1 fw-semibold text-dark" for="${id}">${t.name}<span class="d-block small fw-normal text-muted-gs">${t.bank} no banco</span></label>
          <input id="${id}" name="distribuicao[${t.name}]" data-topic="${t.name}" type="number" min="0" max="50" class="form-control tnum text-center" style="width:5.5rem" value="${distVals[t.name] ?? 0}"></div>`;
      }).join('');
      calc();
    };
    const calc = () => {
      const total = Math.max(0, +$('#sim-total').value || 0), custom = $('#sim-custom').checked, topics = simTopics();
      const alloc = {};
      if (custom) topics.forEach(t => { alloc[t.name] = +(distVals[t.name] ?? 0); });
      else if (topics.length) {
        const base = Math.floor(total / topics.length); let rest = total - base * topics.length;
        topics.forEach(t => { alloc[t.name] = base + (rest-- > 0 ? 1 : 0); });
      }
      let reuse = 0, fresh = 0, sum = 0;
      topics.forEach(t => { const n = alloc[t.name] || 0; sum += n; const r = Math.min(n, t.bank); reuse += r; fresh += n - r; });
      $('#sum-reuse').textContent = reuse;
      $('#sum-new').textContent = fresh;
      $('#sum-bar').style.width = (sum ? reuse / sum * 100 : 0) + '%';
      const ok = !custom || sum === total;
      const icon = '<svg class="ic" aria-hidden="true"><use href="#i-alert"/></svg>';
      $('#sim-dist-alert').innerHTML = !topics.length
        ? `<div class="gs-alert gs-alert-bad">${icon}<div>Selecione pelo menos um tópico.</div></div>`
        : ok ? '' : `<div class="gs-alert gs-alert-bad">${icon}<div>A distribuição soma <strong>${sum}</strong> questões, mas o total é <strong>${total}</strong>. Ajuste os números para somar ${total}.</div></div>`;
      $('#sim-submit').disabled = !ok || !topics.length;
      $('#sum-note').textContent = fresh
        ? `A IA será chamada só para ${fresh} ${fresh === 1 ? 'questão' : 'questões'}; o restante vem do banco.`
        : 'Todas as questões já existem no banco. A IA não será chamada.';
    };
    simTopicsBox.addEventListener('change', renderDist);
    $('#sim-custom').addEventListener('change', renderDist);
    $('#sim-total').addEventListener('input', calc);
    $('#sim-dist').addEventListener('input', e => { if (e.target.dataset.topic) { distVals[e.target.dataset.topic] = +e.target.value || 0; calc(); } });
    renderDist();
  }

  /* ---------- Resolver simulado ----------
     As questões podem vir do backend em window.GERASIM_QUESTOES
     (ex.: <script>window.GERASIM_QUESTOES = @json($questoes)</script>).
     Formato: [{ t: 'Tópico', q: 'Enunciado', a: ['Alt A', ...] }] */
  const examEl = $('#exam');
  if (examEl) {
    const QUESTIONS = window.GERASIM_QUESTOES || [
      { t: 'Triggers', q: 'Qual comando é utilizado para criar uma trigger no PostgreSQL?', a: ['CREATE TRIGGER', 'ADD TRIGGER', 'NEW TRIGGER', 'MAKE TRIGGER'] },
      { t: 'Triggers', q: 'Em uma trigger BEFORE UPDATE, qual variável contém os valores da linha depois da alteração?', a: ['OLD', 'NEW', 'CURRENT', 'ROW'] },
      { t: 'Triggers', q: 'Uma trigger declarada com FOR EACH ROW é disparada:', a: ['Uma única vez por comando SQL', 'Uma vez para cada linha afetada', 'Apenas quando a tabela está vazia', 'Somente em comandos SELECT'] },
      { t: 'Triggers', q: 'Qual é o tipo de retorno de uma função chamada por uma trigger?', a: ['RETURNS VOID', 'RETURNS RECORD', 'RETURNS TRIGGER', 'RETURNS TABLE'] },
      { t: 'Triggers', q: 'Em uma trigger AFTER DELETE, qual registro está disponível com os dados removidos?', a: ['NEW', 'OLD', 'DELETED', 'LAST'] },
      { t: 'Estrutura de Dados', q: 'Em uma pilha, qual elemento é removido primeiro?', a: ['O primeiro inserido', 'O último inserido', 'O menor elemento', 'Um elemento aleatório'] },
      { t: 'Estrutura de Dados', q: 'Qual a complexidade da busca por um valor em uma lista encadeada não ordenada?', a: ['O(1)', 'O(log n)', 'O(n)', 'O(n²)'] },
      { t: 'Estrutura de Dados', q: 'Em uma árvore binária de busca, qual percurso retorna os elementos em ordem crescente?', a: ['Pré-ordem', 'Em ordem (in-order)', 'Pós-ordem', 'Em largura'] },
      { t: 'Funções', q: 'Em PL/pgSQL, qual bloco declara as variáveis de uma função?', a: ['VAR', 'LET', 'DECLARE', 'DEFINE'] },
      { t: 'Funções', q: 'Qual opção informa ao PostgreSQL que a função sempre retorna o mesmo resultado para os mesmos argumentos?', a: ['STABLE', 'VOLATILE', 'STRICT', 'IMMUTABLE'] },
    ];
    const finishUrl = examEl.dataset.finishUrl;
    const exam = { cur: 0, ans: QUESTIONS.map(() => null), flags: new Set() };
    const esc = s => String(s).replace(/[&<>"]/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]));

    const render = () => {
      const q = QUESTIONS[exam.cur], n = QUESTIONS.length;
      $('#ex-count').textContent = `Questão ${exam.cur + 1} de ${n}`;
      $('#ex-qtitle').textContent = `Questão ${exam.cur + 1}`;
      $('#ex-qtopic').textContent = q.t;
      $('#ex-qtext').textContent = q.q;
      $('#ex-alts').innerHTML = q.a.map((t, i) =>
        `<button type="button" role="radio" aria-checked="${exam.ans[exam.cur] === i}" class="gs-alt ${exam.ans[exam.cur] === i ? 'selected' : ''}" data-i="${i}"><span class="letter">${LETTERS[i]}</span>${esc(t)}</button>`).join('');
      $('#ex-steps').innerHTML = QUESTIONS.map((_, i) => `<span class="${i === exam.cur ? 'cur' : exam.ans[i] != null ? 'done' : ''}"></span>`).join('');
      $('#ex-grid').innerHTML = QUESTIONS.map((_, i) =>
        `<button type="button" data-i="${i}" aria-label="Questão ${i + 1}" class="${i === exam.cur ? 'current' : exam.ans[i] != null ? 'answered' : ''} ${exam.flags.has(i) ? 'flag' : ''}">${i + 1}</button>`).join('');
      $('#ex-prev').disabled = exam.cur === 0;
      $('#ex-next').innerHTML = exam.cur === n - 1 ? 'Revisar e finalizar' : 'Próxima<svg class="ic" aria-hidden="true"><use href="#i-arrow-r"/></svg>';
      $('#ex-flag').innerHTML = `<svg class="ic ic-sm" aria-hidden="true"><use href="#i-flag"/></svg>${exam.flags.has(exam.cur) ? 'Remover marcação' : 'Marcar para revisar'}`;
    };
    const finishBox = $('#ex-finish-box');
    const finishButton = () => {
      finishBox.innerHTML = '<button class="btn btn-gs-dark w-100" id="ex-finish">Finalizar simulado</button>';
      $('#ex-finish').addEventListener('click', askFinish);
    };
    const askFinish = () => {
      const blank = exam.ans.filter(a => a == null).length;
      finishBox.innerHTML = `<div class="gs-card">
        <div class="fw-semibold text-dark mb-1">Finalizar simulado?</div>
        <div class="small text-muted-gs mb-3">${blank ? `Você deixou <b class="text-dark">${blank} ${blank === 1 ? 'questão' : 'questões'}</b> em branco. Elas contam como erro.` : 'Todas as questões foram respondidas.'}</div>
        <div class="d-flex gap-2"><button class="btn btn-gs-ghost btn-sm flex-fill" id="ex-cancel">Voltar</button><a href="${finishUrl}" class="btn btn-gs btn-sm flex-fill">Finalizar</a></div></div>`;
      $('#ex-cancel').addEventListener('click', finishButton);
    };
    $('#ex-alts').addEventListener('click', e => { const b = e.target.closest('.gs-alt'); if (!b) return; exam.ans[exam.cur] = +b.dataset.i; render(); });
    $('#ex-grid').addEventListener('click', e => { const b = e.target.closest('button'); if (!b) return; exam.cur = +b.dataset.i; render(); });
    $('#ex-prev').addEventListener('click', () => { if (exam.cur > 0) { exam.cur--; render(); } });
    $('#ex-next').addEventListener('click', () => { if (exam.cur < QUESTIONS.length - 1) { exam.cur++; render(); } else askFinish(); });
    $('#ex-flag').addEventListener('click', () => { exam.flags.has(exam.cur) ? exam.flags.delete(exam.cur) : exam.flags.add(exam.cur); render(); });
    $('#ex-finish').addEventListener('click', askFinish);

    let secs = 0;
    const timer = $('#ex-timer');
    setInterval(() => { secs++; timer.textContent = String(Math.floor(secs / 60)).padStart(2, '0') + ':' + String(secs % 60).padStart(2, '0'); }, 1000);
    render();
  }
})();
