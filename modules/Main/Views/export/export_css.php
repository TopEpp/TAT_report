<style type="text/css">
  *,
  *::before,
  *::after {
    box-sizing: border-box;
  }

  html {
    /* font-family: 'THSarabunPsk'; */
    /* font-color:black; */
    line-height: 1.15;
    -webkit-text-size-adjust: 100%;
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
  }


  table>thead>tr>th {
    text-align: center !important;
    color: #1cc88a !important;
  }

  hr {
    box-sizing: content-box;
    height: 0;
    overflow: visible;
  }

  h1,
  h2,
  h3,
  h4,
  h5,
  h6 {
    margin-top: 0;
    margin-bottom: 0.5rem;
  }

  p {
    margin-top: 0;
    margin-bottom: 1rem;
  }



  img {
    vertical-align: middle;
    border-style: none;
  }


  table {
    border-collapse: collapse;
  }



  th {
    text-align: inherit;
    text-align: -webkit-match-parent;
  }

  label {
    display: inline-block;
    margin-bottom: 0.35rem;
    font-weight: bold;
  }


  h1,
  h2,
  h3,
  h4,
  h5,
  h6,
  .h1,
  .h2,
  .h3,
  .h4,
  .h5,
  .h6 {
    margin-bottom: 0.5rem;
    font-weight: 400;
    line-height: 1;
  }

  h1,
  .h1 {
    font-size: 2.5rem;
  }

  h2,
  .h2 {
    font-size: 2rem;
  }

  h3,
  .h3 {
    font-size: 1.75rem;
  }

  h4,
  .h4 {
    font-size: 1.5rem;
  }

  h5,
  .h5 {
    font-size: 1.25rem;
  }

  h6,
  .h6 {
    font-size: 1rem;
  }

  hr {
    margin-top: 1rem;
    margin-bottom: 1rem;
    border: 0;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
  }

  .container,
  .container-fluid,
  .container-sm,
  .container-md,
  .container-lg,
  .container-xl {
    width: 100%;
    padding-right: 0.75rem;
    padding-left: 0.75rem;
    margin-right: auto;
    margin-left: auto;
    max-width: 1140px;
  }



  .row {
    display: flex;
    flex-wrap: wrap;
    margin-right: -0.75rem;
    margin-left: -0.75rem;
    margin-top: 5px;
  }


  .col-1,
  .col-2,
  .col-3,
  .col-4,
  .col-5,
  .col-6,
  .col-7,
  .col-8,
  .col-9,
  .col-10,
  .col-11,
  .col-12,
  .col,
  .col-auto,
  .col-sm-1,
  .col-sm-2,
  .col-sm-3,
  .col-sm-4,
  .col-sm-5,
  .col-sm-6,
  .col-sm-7,
  .col-sm-8,
  .col-sm-9,
  .col-sm-10,
  .col-sm-11,
  .col-sm-12,
  .col-sm,
  .col-sm-auto,
  .col-md-1,
  .col-md-2,
  .col-md-3,
  .col-md-4,
  .col-md-5,
  .col-md-6,
  .col-md-7,
  .col-md-8,
  .col-md-9,
  .col-md-10,
  .col-md-11,
  .col-md-12,
  .col-md,
  .col-md-auto,
  .col-lg-1,
  .col-lg-2,
  .col-lg-3,
  .col-lg-4,
  .col-lg-5,
  .col-lg-6,
  .col-lg-7,
  .col-lg-8,
  .col-lg-9,
  .col-lg-10,
  .col-lg-11,
  .col-lg-12,
  .col-lg,
  .col-lg-auto,
  .col-xl-1,
  .col-xl-2,
  .col-xl-3,
  .col-xl-4,
  .col-xl-5,
  .col-xl-6,
  .col-xl-7,
  .col-xl-8,
  .col-xl-9,
  .col-xl-10,
  .col-xl-11,
  .col-xl-12,
  .col-xl,
  .col-xl-auto {
    position: relative;
    width: 100%;
    padding-right: 0.65rem;
    padding-left: 0.65rem;
  }

  .col {
    flex-basis: 0;
    flex-grow: 1;
    max-width: 100%;
  }

  .col-md {
    flex-basis: 0;
    flex-grow: 1;
    max-width: 100%;
  }

  .col-md-auto {
    flex: 0 0 auto;
    width: auto;
    max-width: 100%;
  }

  .col-md-1 {
    flex: 0 0 8.33333%;
    max-width: 8.33333%;
  }

  .col-md-2 {
    flex: 0 0 16.66667%;
    max-width: 16.66667%;
  }

  .col-md-3 {
    flex: 0 0 25%;
    max-width: 25%;
  }

  .col-md-4 {
    flex: 0 0 33.33333%;
    max-width: 33.33333%;
  }

  .col-md-5 {
    flex: 0 0 41.66667%;
    max-width: 41.66667%;
  }

  .col-md-6 {
    flex: 0 0 50%;
    max-width: 50%;
  }

  .col-md-7 {
    flex: 0 0 58.33333%;
    max-width: 58.33333%;
  }

  .col-md-8 {
    flex: 0 0 66.66667%;
    max-width: 66.66667%;
  }

  .col-md-9 {
    flex: 0 0 75%;
    max-width: 75%;
  }

  .col-md-10 {
    flex: 0 0 83.33333%;
    max-width: 83.33333%;
  }

  .col-md-11 {
    flex: 0 0 91.66667%;
    max-width: 91.66667%;
  }

  .col-md-12 {
    flex: 0 0 100%;
    max-width: 100%;
  }

  .table {
    width: 100%;
    margin-bottom: 1rem;
    color: #151726;
  }

  .table th,
  .table td {
    padding: 0.25rem;
    vertical-align: middle;
    border-top: 1px solid #e3e6f0;
  }

  .table thead th {
    vertical-align: middle;
    border-bottom: 2px solid #0E66AE;
    text-align: center;
    background-color: #B6E2E9;
    color: #332;
  }

  .table tbody+tbody {
    border-top: 2px solid #e3e6f0;
  }

  .table-sm th,
  .table-sm td {
    padding: 0.3rem;
  }

  .table-bordered {
    border: 1px solid #e3e6f0;
  }

  .table-bordered th,
  .table-bordered td {
    border: 1px solid #e3e6f0;
  }

  .table-bordered thead th,
  .table-bordered thead td {
    border-bottom-width: 2px;
  }

  .table-borderless th,
  .table-borderless td,
  .table-borderless thead th,
  .table-borderless tbody+tbody {
    border: 0;
  }

  .table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(0, 0, 0, 0.02);
  }

  .table-hover tbody tr:hover {
    color: #151726;
    background-color: rgba(0, 0, 0, 0.05);
  }

  .table-primary,
  .table-primary>th,
  .table-primary>td {
    background-color: #cdd8f6;
  }

  .table-primary th,
  .table-primary td,
  .table-primary thead th,
  .table-primary tbody+tbody {
    border-color: #a3b6ee;
  }

  .table-hover .table-primary:hover {
    background-color: #b7c7f2;
  }

  .table-hover .table-primary:hover>td,
  .table-hover .table-primary:hover>th {
    background-color: #b7c7f2;
  }


  .table-responsive {
    display: block;
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }

  .table-responsive>.table-bordered {
    border: 0;
  }

  .form-control {
    display: block;
    width: 100%;
    height: calc(1.3em + 0.55rem + 5px);
    padding: 0.275rem 0.55rem;
    font-size: .9rem;
    font-weight: 400;
    line-height: 1.5;
    color: #6e707e;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #d1d3e2;
    border-radius: 0.35rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
  }

  .card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid #e3e6f0;
    border-radius: 0.35rem;
  }

  .card>hr {
    margin-right: 0;
    margin-left: 0;
  }

  .card>.list-group {
    border-top: inherit;
    border-bottom: inherit;
  }

  .card>.list-group:first-child {
    border-top-width: 0;
    border-top-left-radius: calc(0.35rem - 1px);
    border-top-right-radius: calc(0.35rem - 1px);
  }

  .card>.list-group:last-child {
    border-bottom-width: 0;
    border-bottom-right-radius: calc(0.35rem - 1px);
    border-bottom-left-radius: calc(0.35rem - 1px);
  }

  .card>.card-header+.list-group,
  .card>.list-group+.card-footer {
    border-top: 0;
  }

  .card-body {
    flex: 1 1 auto;
    min-height: 1px;
    padding: 0.5rem;
    height: 300px;
  }

  .card-title {
    margin-bottom: 0.75rem;
  }

  .card-subtitle {
    margin-top: -0.375rem;
    margin-bottom: 0;
  }

  .card-text:last-child {
    margin-bottom: 0;
  }

  .card-link:hover {
    text-decoration: none;
  }

  .card-link+.card-link {
    margin-left: 1.25rem;
  }

  .card-header {
    padding: 0.5rem 1.0rem;
    margin-bottom: 0;
    background-color: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
  }

  .card-header-no_border {
    padding: 0.5rem 1.0rem;
    margin-bottom: 0;
    font-size: 16px;
  }

  .card-header-no_border>a {
    font-size: 16px;
  }

  .card-header:first-child {
    border-radius: calc(0.35rem - 1px) calc(0.35rem - 1px) 0 0;
  }

  .card-footer {
    padding: 0.25rem 0.5rem;
    background-color: #f8f9fc;
    border-top: 1px solid #e3e6f0;
  }

  .card-footer:last-child {
    border-radius: 0 0 calc(0.35rem - 1px) calc(0.35rem - 1px);
  }

  .card-header-tabs {
    margin-right: -0.625rem;
    margin-bottom: -0.75rem;
    margin-left: -0.625rem;
    border-bottom: 0;
  }

  .card-header-pills {
    margin-right: -0.625rem;
    margin-left: -0.625rem;
  }

  .card-img-overlay {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    padding: 1.25rem;
    border-radius: calc(0.35rem - 1px);
  }

  .card-img,
  .card-img-top,
  .card-img-bottom {
    flex-shrink: 0;
    width: 100%;
  }

  .card-img,
  .card-img-top {
    border-top-left-radius: calc(0.35rem - 1px);
    border-top-right-radius: calc(0.35rem - 1px);
  }

  .card-img,
  .card-img-bottom {
    border-bottom-right-radius: calc(0.35rem - 1px);
    border-bottom-left-radius: calc(0.35rem - 1px);
  }

  .card-deck .card {
    margin-bottom: 0.75rem;
  }

  .bg-primary {
    background-color: #0E66AE !important;
  }


  .bg-secondary {
    background-color: #858796 !important;
  }

  .bg-success {
    background-color: #1cc88a !important;
  }


  .bg-info {
    background-color: #36b9cc !important;
  }


  .bg-warning {
    background-color: #f6c23e !important;
  }


  .bg-danger {
    background-color: #e74a3b !important;
  }


  .bg-light {
    background-color: #f8f9fc !important;
  }


  .bg-dark {
    background-color: #5a5c69 !important;
  }


  .bg-white {
    background-color: #fff !important;
  }

  .bg-orange {
    background-color: #0E66AE !important;
  }

  .bg-transparent {
    background-color: transparent !important;
  }
</style>