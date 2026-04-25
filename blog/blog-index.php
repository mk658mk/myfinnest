<?php
// ─── CONFIG ──────────────────────────────────────────────────────────────────
// Folder where your blog HTML files live (relative to this PHP file)
$blog_folder = __DIR__;

// Files to skip (this index file itself, and any non-article pages)
$skip_files = ['blog-index.php', 'index.php', 'index.html'];

// ─── ARTICLE METADATA ────────────────────────────────────────────────────────
// Maps filename → [Title, Category, Read time (min), Short description]
// Add a new row here whenever you upload a new article.
$article_meta = [
  'what-is-sip.html'                 => ['What is SIP and How Does It Work in India?',             'Mutual Funds', 7,  'Learn how SIP, Rupee Cost Averaging and compounding work together to build long-term wealth.'],
  '50-30-20-rule.html'               => ['The 50-30-20 Budgeting Rule: Does It Work for Indians?',  'Budgeting',     6,  'Adapting the global budgeting framework for India's metros, EMIs, and higher savings needs.'],
  'inflation-india.html'             => ['How Inflation Silently Erodes Your Savings in India',     'Basics',        6,  'See exactly how 6% annual inflation destroys purchasing power — and how to fight back.'],
  //'compound-interest-explained.html' => ['Compound Interest Explained: The Secret to Building Wealth','Basics',       6,  'Understand why Einstein called compound interest the eighth wonder of the world.'],
  //'how-emi-works.html'               => ['How Does EMI Work? A Complete Guide for Indian Borrowers','Loans',         7,  'Decode the EMI formula, amortisation schedule and smart strategies to cut total interest paid.'],
  //'loan-prepayment-guide.html'       => ['Loan Prepayment: Should You Prepay or Invest?',           'Loans',         8,  'A data-driven comparison of loan prepayment vs investing in mutual funds.'],
  ///'what-is-fire.html'                => ['What is FIRE? Can You Retire Early in India?',            'FIRE',          8,  'The 4% rule, FIRE corpus calculation, and realistic steps for early retirement in India.'],
  //'retirement-planning-india.html'   => ['Retirement Planning: How Much Do You Really Need?',       'Retirement',    9,  'Step-by-step corpus calculation and asset allocation for a comfortable Indian retirement.'],
  //'child-education-planning.html'    => ["Planning Your Child's Education Fund",                    'Family Finance',8,  'Education inflation is 9% p.a. — here is how to stay ahead of it from day one.'],
  //'nps-complete-guide.html'          => ['NPS Complete Guide: Should You Invest?',                  'Retirement',    8,  'All NPS tax benefits, returns, withdrawal rules and comparison with EPF and PPF.'],
  //'swp-retirement-income.html'       => ['SWP: Create a Monthly Income from Mutual Funds',          'Retirement',    7,  'How Systematic Withdrawal Plans beat annuities and FDs for tax-efficient retirement income.'],
  //'first-crore-guide.html'           => ['How to Save Your First ₹1 Crore: A Roadmap',             'Wealth Building',8, 'A step-by-step plan to reach your first crore at every income level.'],
  //'emergency-fund-guide.html'        => ['Emergency Fund: How Much and Where to Keep It?',          'Basics',        6,  'Build the financial safety net that protects all your other investments.'],
  //'mutual-funds-vs-fd.html'          => ['Mutual Funds vs Fixed Deposits: Which is Better?',        'Investing',     7,  'A numbers-first comparison of net post-tax returns across FD and equity mutual funds.'],
  //'home-loan-guide.html'             => ['Home Loan in India: Everything Before You Borrow',        'Loans',         8,  'Buy vs rent, affordability, tax benefits, and smart strategies to save lakhs on your home loan.'],
  //'step-up-sip.html'                 => ['Step-Up SIP: Grow Your Wealth With Every Raise',          'Mutual Funds',  6,  'How a 10% annual SIP step-up can nearly double your final corpus over 20 years.'],
  //'index-funds-india.html'           => ['Index Funds in India: The Low-Cost Path to Returns',      'Investing',     7,  'Why Warren Buffett recommends index funds — and how to build a simple 3-fund portfolio in India.'],
  //'term-insurance-guide.html'        => ['Term Insurance in India: Why You Need It',                'Insurance',     7,  'How much cover you need, why pure term beats endowment, and how to choose the right policy.'],
  //'ppf-complete-guide.html'          => ['PPF: Your Complete Guide to Public Provident Fund',        'Tax Saving',    7,  'EEE tax status, deposit rules, partial withdrawals, and how to maximise your PPF returns.'],
  //'elss-guide.html'                  => ['ELSS: The Tax-Saving Fund with the Shortest Lock-In',     'Tax Saving',    7,  'How ELSS beats other 80C options on returns, lock-in period, and tax efficiency.'],
  //'gold-investment-india.html'       => ['Investing in Gold: Physical, SGB, ETF Compared',          'Investing',     7,  'Why Sovereign Gold Bonds beat every other form of gold investment in India.'],
  //'tax-saving-investments-india.html'=> ['Best Tax-Saving Investments Under Section 80C (2024–25)', 'Tax Saving',    7,  'Compare all 80C options and build the optimal tax-saving strategy for your income level.'],
];

// ─── COLLECT ARTICLES ─────────────────────────────────────────────────────────
$articles = [];
foreach (glob($blog_folder . '/*.html') as $filepath) {
  $filename = basename($filepath);
  if (in_array($filename, $skip_files)) continue;

  if (isset($article_meta[$filename])) {
    [$title, $category, $read_time, $desc] = $article_meta[$filename];
  } else {
    // Fallback for any new article uploaded without meta entry
    $title     = ucwords(str_replace(['-', '.html'], [' ', ''], $filename));
    $category  = 'General';
    $read_time = '—';
    $desc      = 'Read the full article for detailed insights.';
  }

  $articles[] = [
    'file'      => $filename,
    'title'     => $title,
    'category'  => $category,
    'read_time' => $read_time,
    'desc'      => $desc,
  ];
}

// Sort alphabetically by title
usort($articles, fn($a, $b) => strcmp($a['title'], $b['title']));

// Get unique categories for filter buttons
$categories = array_unique(array_column($articles, 'category'));
sort($categories);

$total = count($articles);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="description" content="Personal finance articles for Indians — SIP, EMI, FIRE, retirement planning, tax saving and more."/>
  <title>Blog | My Finance Nest</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --bg:       #f4f7f2;
      --surface:  #ffffff;
      --text:     #1a2410;
      --muted:    #6b7a62;
      --accent:   #2e7d32;
      --accent2:  #81c784;
      --border:   #dde8d8;
      --card-shadow: 0 2px 12px rgba(46,125,50,0.08);
      --radius:   12px;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    body {
      background: var(--bg);
      color: var(--text);
      font-family: 'DM Sans', sans-serif;
      font-size: 16px;
      line-height: 1.6;
    }

    /* ── HEADER ── */
    header {
      background: var(--surface);
      border-bottom: 3px solid var(--accent);
      padding: 18px 32px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 100;
      box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }
    .logo { text-decoration: none; display: flex; align-items: center; gap: 10px; }
    .logo-icon {
      width: 38px; height: 38px; background: var(--accent);
      border-radius: 8px; display: flex; align-items: center;
      justify-content: center; color: #fff; font-size: 1.2rem; font-weight: 800;
    }
    .logo-text { font-family: 'Playfair Display', serif; font-size: 1.2rem; color: var(--text); font-weight: 700; }
    .header-tools { display: flex; align-items: center; gap: 14px; }
    .header-tools a {
      text-decoration: none; color: var(--muted); font-size: 0.88rem;
      font-weight: 500; transition: color .2s;
    }
    .header-tools a:hover { color: var(--accent); }

    /* ── HERO ── */
    .hero {
      background: linear-gradient(135deg, var(--accent) 0%, #1b5e20 100%);
      color: #fff;
      padding: 60px 32px 50px;
      text-align: center;
      position: relative;
      overflow: hidden;
    }
    .hero::before {
      content: '';
      position: absolute; inset: 0;
      background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
      pointer-events: none;
    }
    .hero h1 { font-family: 'Playfair Display', serif; font-size: 2.4rem; margin-bottom: 12px; position: relative; }
    .hero p { font-size: 1.05rem; opacity: 0.88; max-width: 520px; margin: 0 auto 24px; position: relative; }
    .article-count {
      display: inline-block; background: rgba(255,255,255,0.15);
      border: 1px solid rgba(255,255,255,0.3);
      border-radius: 30px; padding: 6px 20px;
      font-size: 0.88rem; font-weight: 600; position: relative;
    }

    /* ── CONTROLS ── */
    .controls {
      max-width: 1100px; margin: 0 auto;
      padding: 28px 24px 0;
      display: flex; flex-wrap: wrap; gap: 14px;
      align-items: center; justify-content: space-between;
    }
    .search-wrap { position: relative; flex: 1; min-width: 200px; max-width: 340px; }
    .search-wrap input {
      width: 100%; padding: 10px 14px 10px 40px;
      border: 1.5px solid var(--border); border-radius: 8px;
      font-size: 0.93rem; background: var(--surface);
      color: var(--text); outline: none; transition: border-color .2s;
      font-family: 'DM Sans', sans-serif;
    }
    .search-wrap input:focus { border-color: var(--accent); }
    .search-wrap::before {
      content: '🔍'; position: absolute;
      left: 12px; top: 50%; transform: translateY(-50%);
      font-size: 0.85rem; pointer-events: none;
    }
    .filters { display: flex; flex-wrap: wrap; gap: 8px; }
    .filter-btn {
      padding: 7px 16px; border-radius: 30px; border: 1.5px solid var(--border);
      background: var(--surface); color: var(--muted);
      font-size: 0.82rem; font-weight: 600; cursor: pointer;
      transition: all .2s; font-family: 'DM Sans', sans-serif;
      white-space: nowrap;
    }
    .filter-btn:hover, .filter-btn.active {
      background: var(--accent); border-color: var(--accent); color: #fff;
    }

    /* ── RESULTS BAR ── */
    .results-bar {
      max-width: 1100px; margin: 16px auto 0;
      padding: 0 24px;
      font-size: 0.85rem; color: var(--muted); font-weight: 500;
    }

    /* ── GRID ── */
    .grid {
      max-width: 1100px; margin: 20px auto 60px;
      padding: 0 24px;
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 20px;
    }

    /* ── CARD ── */
    .card {
      background: var(--surface);
      border: 1.5px solid var(--border);
      border-radius: var(--radius);
      padding: 24px;
      display: flex; flex-direction: column;
      box-shadow: var(--card-shadow);
      transition: transform .2s, box-shadow .2s, border-color .2s;
      text-decoration: none; color: inherit;
      position: relative; overflow: hidden;
    }
    .card::after {
      content: '';
      position: absolute; top: 0; left: 0; right: 0;
      height: 3px;
      background: var(--accent);
      transform: scaleX(0); transform-origin: left;
      transition: transform .25s ease;
    }
    .card:hover { transform: translateY(-4px); box-shadow: 0 8px 28px rgba(46,125,50,0.15); border-color: var(--accent2); }
    .card:hover::after { transform: scaleX(1); }

    .card-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
    .cat-tag {
      font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px;
      padding: 4px 12px; border-radius: 20px;
      background: #e8f5e9; color: var(--accent);
    }
    .read-time { font-size: 0.78rem; color: var(--muted); }

    .card h2 {
      font-family: 'Playfair Display', serif;
      font-size: 1.05rem; font-weight: 700; line-height: 1.35;
      margin-bottom: 10px; color: var(--text);
    }
    .card p { font-size: 0.88rem; color: var(--muted); line-height: 1.55; flex: 1; }
    .card-footer {
      margin-top: 18px; padding-top: 14px;
      border-top: 1px solid var(--border);
      display: flex; align-items: center; justify-content: space-between;
    }
    .read-link {
      font-size: 0.85rem; font-weight: 600; color: var(--accent);
      display: flex; align-items: center; gap: 5px;
    }
    .read-link .arrow { transition: transform .2s; }
    .card:hover .arrow { transform: translateX(4px); }

    /* ── NO RESULTS ── */
    .no-results {
      grid-column: 1 / -1; text-align: center;
      padding: 60px 20px; color: var(--muted);
    }
    .no-results .emoji { font-size: 3rem; display: block; margin-bottom: 12px; }

    /* ── FOOTER ── */
    footer {
      text-align: center; padding: 30px 20px;
      border-top: 1px solid var(--border);
      color: var(--muted); font-size: 0.82rem;
    }
    footer a { color: var(--accent); text-decoration: none; }

    /* ── RESPONSIVE ── */
    @media (max-width: 600px) {
      .hero h1 { font-size: 1.7rem; }
      header { padding: 14px 18px; }
      .controls { padding: 20px 16px 0; }
      .grid { padding: 0 16px; gap: 14px; }
    }
  </style>
</head>
<body>

<header>
  <a class="logo" href="https://www.myfinnest.com/">
    <div class="logo-icon">₹</div>
    <span class="logo-text">My Finance Nest</span>
  </a>
  <div class="header-tools">
    <a href="https://www.myfinnest.com/">Calculators</a>
    <a href="https://www.myfinnest.com/terms_privacy/about.html">About</a>
  </div>
</header>

<div class="hero">
  <h1>Personal Finance Blog</h1>
  <p>Simple, jargon-free guides to help every Indian grow, protect, and plan their money.</p>
  <span class="article-count">📚 <?= $total ?> Articles & Growing</span>
</div>

<div class="controls">
  <div class="search-wrap">
    <input type="text" id="searchInput" placeholder="Search articles…" autocomplete="off"/>
  </div>
  <div class="filters">
    <button class="filter-btn active" data-cat="all">All</button>
    <?php foreach ($categories as $cat): ?>
    <button class="filter-btn" data-cat="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></button>
    <?php endforeach; ?>
  </div>
</div>

<div class="results-bar" id="resultsBar">
  Showing all <?= $total ?> articles
</div>

<div class="grid" id="articleGrid">
<?php foreach ($articles as $article): ?>
  <a class="card"
     href="<?= htmlspecialchars($article['file']) ?>"
     data-cat="<?= htmlspecialchars($article['category']) ?>"
     data-title="<?= strtolower(htmlspecialchars($article['title'] . ' ' . $article['category'])) ?>">

    <div class="card-top">
      <span class="cat-tag"><?= htmlspecialchars($article['category']) ?></span>
      <span class="read-time">⏱ <?= $article['read_time'] ?> min</span>
    </div>

    <h2><?= htmlspecialchars($article['title']) ?></h2>
    <p><?= htmlspecialchars($article['desc']) ?></p>

    <div class="card-footer">
      <span class="read-link">Read article <span class="arrow">→</span></span>
    </div>
  </a>
<?php endforeach; ?>
</div>

<footer>
  ⚠️ For educational purposes only. Not financial advice.<br/><br/>
  <a href="https://www.myfinnest.com/">Home</a> &nbsp;·&nbsp;
  <a href="https://www.myfinnest.com/terms_privacy/privacy.html">Privacy Policy</a> &nbsp;·&nbsp;
  <a href="https://www.myfinnest.com/terms_privacy/disclaimer.html">Disclaimer</a><br/><br/>
  © <?= date('Y') ?> My Finance Nest. All rights reserved.
</footer>

<script>
  const cards    = document.querySelectorAll('.card');
  const searchEl = document.getElementById('searchInput');
  const filters  = document.querySelectorAll('.filter-btn');
  const bar      = document.getElementById('resultsBar');

  let activeCat = 'all';
  let searchVal = '';

  function filterCards() {
    let visible = 0;
    cards.forEach(card => {
      const matchCat    = activeCat === 'all' || card.dataset.cat === activeCat;
      const matchSearch = card.dataset.title.includes(searchVal);
      const show = matchCat && matchSearch;
      card.style.display = show ? '' : 'none';
      if (show) visible++;
    });

    // no-results message
    let noRes = document.querySelector('.no-results');
    if (visible === 0) {
      if (!noRes) {
        noRes = document.createElement('div');
        noRes.className = 'no-results';
        noRes.innerHTML = '<span class="emoji">🔍</span><strong>No articles found</strong><br/>Try a different search or category.';
        document.getElementById('articleGrid').appendChild(noRes);
      }
    } else if (noRes) {
      noRes.remove();
    }

    bar.textContent = visible === cards.length
      ? `Showing all ${cards.length} articles`
      : `Showing ${visible} of ${cards.length} articles`;
  }

  filters.forEach(btn => {
    btn.addEventListener('click', () => {
      filters.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      activeCat = btn.dataset.cat;
      filterCards();
    });
  });

  searchEl.addEventListener('input', () => {
    searchVal = searchEl.value.toLowerCase().trim();
    filterCards();
  });
</script>
</body>
</html>
