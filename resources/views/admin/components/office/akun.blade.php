{{-- resources/views/admin/office/akun.blade.php --}}

<style>
    .akun-toolbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
    .akun-btn-edit {
        background: #E5D6C5; color: #582C0C;
        border: none; padding: 8px 20px;
        border-radius: 5px; font-size: 13px; font-weight: 700;
        cursor: pointer; font-family: inherit; letter-spacing: .3px;
        transition: background .2s;
    }
    .akun-btn-edit:hover { background: #d4c3b0; }
    .akun-date-row { display: flex; align-items: center; gap: 8px; }
    .akun-date-input {
        border: none; border-bottom: 1.5px solid #E5D6C5;
        padding: 4px 0; font-size: 13px; color: #582C0C; font-weight: 600;
        outline: none; background: transparent; width: 110px; font-family: inherit;
    }
    .akun-date-input:focus { border-color: #C58F59; }
    .akun-sep { color: #6B513E; }
    .akun-btn-refresh {
        width: 32px; height: 32px; border: 1.5px solid #E5D6C5; border-radius: 5px;
        background: #fff; color: #C58F59;
        display: inline-flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all .2s;
    }
    .akun-btn-refresh:hover { border-color: #C58F59; }

    /* account cards */
    .akun-cards-row { display: flex; gap: 14px; margin-bottom: 20px; flex-wrap: wrap; }
    .akun-card {
        background: #fff; border: 1px solid #E5D6C5; border-radius: 8px;
        padding: 20px 24px; min-width: 200px; flex: 0 0 auto;
        box-shadow: 0 1px 3px rgba(88,44,12,.05); text-align: center;
    }
    .akun-card-name   { font-size: 13px; font-weight: 700; color: #C58F59; margin: 0 0 10px; }
    .akun-card-total  { font-size: 18.75px; font-weight: 700; color: #10B981; margin: 0 0 6px; }
    .akun-card-total.red { color: #EF4444; }
    .akun-card-detail { font-size: 13px; color: #6B513E; margin: 0; }
    .akun-card-detail .plus  { color: #10B981; font-weight: 600; }
    .akun-card-detail .minus { color: #EF4444; font-weight: 600; }

    /* chart */
    .akun-chart-wrap {
        background: #fff; border: 1px solid #E5D6C5; border-radius: 8px;
        padding: 10px 0 0; overflow: hidden;
        box-shadow: 0 1px 3px rgba(88,44,12,.05);
    }
    .akun-chart-inner { position: relative; height: 340px; }

    /* y-axis labels */
    .akun-y { position: absolute; left: 0; top: 0; bottom: 32px; width: 52px; display: flex; flex-direction: column-reverse; justify-content: space-between; padding: 4px 0; }
    .akun-y span { font-size: 13px; color: #9CA3AF; text-align: right; padding-right: 8px; }

    /* chart plot area */
    .akun-plot { position: absolute; left: 52px; right: 0; top: 0; bottom: 32px; }
    .akun-area-fill {
        position: absolute; inset: 0;
        background: linear-gradient(to bottom, rgba(148,130,235,.55), rgba(148,130,235,.08));
        border-top: 2px solid rgba(148,130,235,.8);
        border-radius: 2px;
    }
    /* grid lines */
    .akun-gridline {
        position: absolute; left: 0; right: 0; height: 1px;
        border-top: 1px dashed #E5D6C5;
    }

    /* x-axis */
    .akun-x { position: absolute; left: 52px; right: 0; bottom: 0; height: 32px; display: flex; justify-content: space-between; align-items: center; padding: 0 4px; }
    .akun-x span { font-size: 13px; color: #9CA3AF; }
</style>

<div class="akun-toolbar">
    <button class="akun-btn-edit">EDIT AKUN</button>
    <div class="akun-date-row">
        <input type="text" class="akun-date-input" value="01/03/2026">
        <span class="akun-sep">-</span>
        <input type="text" class="akun-date-input" value="31/03/2026">
        <button class="akun-btn-refresh">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 4v6h-6M1 20v-6h6"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
        </button>
    </div>
</div>

<div class="akun-cards-row">
    <div class="akun-card">
        <p class="akun-card-name">Kas</p>
        <p class="akun-card-total">Rp246.150.000</p>
        <p class="akun-card-detail">
            <span class="plus">+Rp3.600.000</span>
            /
            <span class="minus">-Rp0</span>
        </p>
    </div>
    <div class="akun-card">
        <p class="akun-card-name">Cover BPJS</p>
        <p class="akun-card-total">Rp0</p>
        <p class="akun-card-detail">
            <span class="plus">+Rp0</span>
            /
            <span class="minus">-Rp0</span>
        </p>
    </div>
</div>

{{-- Area Chart (static illustration) --}}
<div class="akun-chart-wrap">
    <div class="akun-chart-inner">

        {{-- Y gridlines --}}
        <div class="akun-y">
            <span>0%</span>
            <span>25%</span>
            <span>50%</span>
            <span>75%</span>
            <span>100%</span>
        </div>
        <div class="akun-plot">
            <div class="akun-gridline" style="bottom:0%;"></div>
            <div class="akun-gridline" style="bottom:25%;"></div>
            <div class="akun-gridline" style="bottom:50%;"></div>
            <div class="akun-gridline" style="bottom:75%;"></div>
            <div class="akun-gridline" style="bottom:100%;"></div>

            {{-- Filled area --}}
            <div class="akun-area-fill"></div>
        </div>

        {{-- X axis --}}
        <div class="akun-x">
            <span>March 25</span>
            <span>April 25</span>
            <span>May 25</span>
            <span>June 25</span>
            <span>July 25</span>
            <span>September 25</span>
            <span>November 25</span>
            <span>January 26</span>
            <span>March 26</span>
        </div>

    </div>
</div>
