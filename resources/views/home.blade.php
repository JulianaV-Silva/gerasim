@extends('layouts.public')

@section('title', 'Início')

@section('content')
{{-- @partial: layouts/partials/public-nav.blade.php --}}
<header class="gs-lnav">
  <div class="gs-lwrap d-flex justify-content-between align-items-center">
    <a href="{{ route('home') }}" class="gs-brand gs-brand-dark p-0">@include('layouts.partials.logo') <span>GERA<span class="sim">SIM</span></span></a>
    <nav class="d-flex align-items-center gap-2">
      <a href="#funcionalidades" class="gs-lnav-link d-none d-md-inline">Funcionalidades</a>
      <a href="#como-funciona" class="gs-lnav-link d-none d-md-inline me-2">Como funciona</a>
      <a href="{{ route('login') }}" class="btn btn-gs-outline">Entrar</a>
      <a href="{{ route('register') }}" class="btn btn-gs d-none d-sm-inline-flex">Criar conta</a>
    </nav>
  </div>
</header>

{{-- Hero --}}
<div class="gs-hero">
  <div class="gs-lwrap gs-hero-grid">
    <div class="gs-hero-copy">
      <h1>Aprender é<br><span class="gs-grad-text">praticar.</span></h1>
      <p>Transforme seus slides e materiais de estudo em simulados personalizados. O GeraSim usa inteligência artificial para criar questões com base no seu conteúdo, ajudando você a praticar, identificar seus pontos fracos e chegar mais preparado para a prova. Além de disponibilizar um dashboard personalizado para você.</p>
      <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('register') }}" class="btn btn-gs btn-lg">Criar conta grátis</a>
        <a href="#como-funciona" class="btn btn-gs-outline btn-lg">Ver como funciona</a>
      </div>
    </div>
    <div class="gs-hero-art" aria-hidden="true">
      <div class="gs-hero-orb"></div>
      <div class="gs-hero-ring"></div>
      <div class="gs-float gs-float-q">
        <div class="d-flex justify-content-between align-items-center mb-2"><span class="gs-chip">Banco de Dados</span><b class="small text-primary tnum">Questão 2 / 15</b></div>
        <div class="gs-steps mb-3"><span class="done"></span><span class="cur"></span><span></span><span></span><span></span><span></span></div>
        <p class="fw-semibold text-dark small mb-2">Qual comando é utilizado para selecionar e recuperar dados de uma tabela em um banco de dados?</p>
        <div class="gs-alts" style="gap:.4rem">
          <div class="gs-alt py-2"><span class="letter">A</span>DELETE</div>
          <div class="gs-alt py-2"><span class="letter">B</span>UPDATE</div>
          <div class="gs-alt py-2 selected"><span class="letter">C</span>SELECT</div>
        </div>
      </div>
      <div class="gs-float gs-float-chart">
        <div class="fw-semibold text-dark small mb-2">Desempenho por tópico</div>
        <div class="gs-mini-bars"><div><span style="height:82%"></span><small>SQL</small></div><div><span style="height:46%;background:linear-gradient(180deg,#b066d8,#8b5fd6)"></span><small>REDES</small></div><div><span style="height:100%"></span><small>JAVA</small></div></div>
      </div>
      <div class="gs-float gs-float-pts"><x-icon name="trending" /><div><b>+26 pts</b><small>de evolução em 5 meses</small></div></div>
      <div class="gs-float gs-float-file"><span class="gs-icon-tile t-soft" style="width:36px;height:36px"><x-icon name="file" /></span><div><b>aula-banco-de-dados.pdf</b><small><i class="gs-dot"></i>Questões geradas · 15</small></div></div>
    </div>
  </div>
</div>

{{-- Funcionalidades --}}
<div class="gs-lsection" id="funcionalidades">
  <div class="gs-lwrap">
    <h2 class="gs-lh2">Conheça nossas <span class="gs-grad-text">funcionalidades</span></h2>
    <div class="row g-3">
      {{-- @component: x-feature-card --}}
      <div class="col-sm-6 col-lg-3"><div class="gs-card gs-feature h-100">
        <div class="gs-feature-art">
          <div class="gs-mini-file"><span class="gs-tag-ext">PDF</span><b>Redes_Aula03.pdf</b><small>2,4 MB</small></div>
          <div class="gs-mini-file"><span class="gs-tag-ext ppt">PPT</span><b>Slides_Normalização</b><small>18 slides</small></div>
          <div class="gs-mini-file"><span class="gs-tag-ext txt">TXT</span><b>Anotações_prova.txt</b><small>3 KB</small></div>
        </div>
        <div class="gs-feature-num"><span class="gs-icon-tile" style="width:30px;height:30px;border-radius:9px"><x-icon name="upload" class="ic-sm" /></span>01</div>
        <h3>Envie seu material</h3><p>PDFs, slides ou anotações. Do jeito que você já estuda.</p>
      </div></div>
      <div class="col-sm-6 col-lg-3"><div class="gs-card gs-feature h-100">
        <div class="gs-feature-art">
          <div class="bg-white rounded-3 p-2 position-relative">
            <span class="gs-chip mb-2" style="font-size:.66rem">Gerada pela IA</span>
            <div class="gs-skel" style="width:90%"></div><div class="gs-skel mb-2" style="width:60%"></div>
            <div class="gs-alt py-1 mb-1" style="font-size:.74rem"><span class="letter" style="width:20px;height:20px">A</span>Opção A</div>
            <div class="gs-alt py-1 selected" style="font-size:.74rem"><span class="letter" style="width:20px;height:20px">B</span>Opção B</div>
            <svg class="ic position-absolute" style="top:6px;right:6px;color:#a565d8"><use href="#i-sparkles"/></svg>
          </div>
        </div>
        <div class="gs-feature-num"><span class="gs-icon-tile" style="width:30px;height:30px;border-radius:9px"><x-icon name="zap" class="ic-sm" /></span>02</div>
        <h3>IA gera as questões</h3><p>Simulados criados a partir do seu conteúdo, com a dificuldade que você escolher.</p>
      </div></div>
      <div class="col-sm-6 col-lg-3"><div class="gs-card gs-feature h-100">
        <div class="gs-feature-art gs-feature-bars">
          <x-topic-progress :value="82" display="82%">SQL</x-topic-progress>
          <x-topic-progress :value="76" display="76%">Modelagem</x-topic-progress>
          <x-topic-progress :value="38" display="38%" weak>Normalização</x-topic-progress>
          <x-topic-progress :value="66" display="66%">Transações</x-topic-progress>
        </div>
        <div class="gs-feature-num"><span class="gs-icon-tile" style="width:30px;height:30px;border-radius:9px"><x-icon name="chart" class="ic-sm" /></span>03</div>
        <h3>Dashboard personalizado</h3><p>Acompanhe seu progresso e descubra onde estão seus pontos fracos.</p>
      </div></div>
      <div class="col-sm-6 col-lg-3"><div class="gs-card gs-feature h-100">
        <div class="gs-feature-art">
          <div class="gs-mini-file"><b>Normalização</b><small class="ms-auto"><s>38%</s> → <b class="text-dark">71%</b></small></div>
          <div class="gs-mini-file"><b>Transações</b><small class="ms-auto"><s>66%</s> → <b class="text-dark">80%</b></small></div>
          <div class="btn btn-gs btn-sm w-100 mt-1" style="border-radius:10px;font-size:.74rem"><x-icon name="refresh" class="ic-sm" />Refazer o que mais errei</div>
        </div>
        <div class="gs-feature-num"><span class="gs-icon-tile" style="width:30px;height:30px;border-radius:9px"><x-icon name="refresh" class="ic-sm" /></span>04</div>
        <h3>Refaça e evolua</h3><p>Repita os temas em que você mais errou até dominar o conteúdo.</p>
      </div></div>
    </div>
  </div>
</div>

{{-- Como funciona --}}
<div class="gs-lsection pt-0" id="como-funciona">
  <div class="gs-lwrap">
    <h2 class="gs-lh2">Como <span class="gs-grad-text">funciona</span></h2>
    <ol class="gs-how">
      <li><span class="n">1</span><h3>Envie seu material</h3><p>PDFs, slides ou anotações de qualquer matéria.</p></li>
      <li><span class="n">2</span><h3>A IA cria o simulado</h3><p>Questões personalizadas feitas sobre o seu conteúdo.</p></li>
      <li><span class="n">3</span><h3>Pratique e evolua</h3><p>Acompanhe sua evolução e refaça o que errou.</p></li>
    </ol>
    <div class="gs-cta">
      <h2>Pronto para parar de estudar no escuro?</h2>
      <a href="{{ route('register') }}" class="btn btn-light btn-lg text-primary">Criar conta grátis<x-icon name="arrow-r" /></a>
    </div>
  </div>
</div>

{{-- @partial: layouts/partials/footer.blade.php --}}
<footer class="gs-footer">
  <div class="gs-lwrap">
    <div class="row g-4">
      <div class="col-md-4"><div class="gs-brand p-0">@include('layouts.partials.logo') <span>GERA<span class="sim">SIM</span></span></div><p class="mt-3 small" style="max-width:18rem">Simulados personalizados a partir dos seus materiais de estudo.</p></div>
      <div class="col-6 col-md-3"><h4>Plataforma</h4><a href="#funcionalidades">Funcionalidades</a><a href="#como-funciona">Como funciona</a><a href="{{ route('register') }}">Criar conta</a></div>
      <div class="col-6 col-md-3"><h4>Suporte</h4><a href="{{ route('home') }}">Central de Ajuda</a><a href="{{ route('home') }}">Contato</a></div>
      <div class="col-md-2"><h4>Nossas redes</h4><div class="d-flex gap-3"><a href="{{ route('home') }}" aria-label="Instagram"><x-icon name="instagram" class="ic-lg" /></a><a href="{{ route('home') }}" aria-label="Facebook"><x-icon name="facebook" class="ic-lg" /></a></div></div>
    </div>
    <div class="gs-footer-bottom"><span>© 2026 GeraSim. Todos os direitos reservados.</span><span class="d-flex gap-3"><a href="{{ route('home') }}">Termos de Uso</a><a href="{{ route('home') }}">Central de Privacidade</a></span></div>
  </div>
</footer>
@endsection
