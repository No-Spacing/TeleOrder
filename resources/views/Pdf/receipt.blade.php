<style>
body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 12px;
}
.container {
    width: 90%;
    margin: 30 auto;
    padding: 10px;
    box-sizing: border-box;
}
.header,
.footer {
    width: 100%;
    text-align: left;
    margin-bottom: 10px;
}
.title {
    text-align: center;
    font-weight: bold;
    font-size: 16px;
    margin-bottom: 10px;
}
.btn-container {
    margin: auto;
    text-align: right;
}
.download-btn {
    font-weight: bold;
    background-color: #4CAF50;
    border-radius: 5px;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}
.info-table {
    width: 100%;
    margin-bottom: 10px;
}
.info-table td {
    /* padding: 2px 5px; */
    vertical-align: top;
}
.data-table {
    width: 100%;
    border-collapse: collapse;
    padding-top: 10px;
    padding-bottom: 10px;
}
.data-table th,
.data-table td {
    border: 1px solid #000;
    padding: 4px;
    text-align: center;
    font-size: 11px;
}
.footer {
    margin-top: 10px;
    font-weight: bold;
}
</style>
<div class="container">
    <div class="title">STOCK CARD</div>
    <table class="info-table">
        <tr>
            <td><strong>Product: </strong></td>
            <td><strong>UOM: </strong></td>
        </tr>
        <tr>
            <td><strong>Description: </strong></td>
            <td><strong>Date/Time Generated:</strong></td>
            <td><strong>Total Items: </strong></td>
        </tr>

    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th>Transaction Date</th>  
                <th>Batch/Lot/Serial No.</th>
                <th>Transaction Type</th>
                <th>Quantity</th>
                <th>Balance</th>
                <th>Warehouse</th>
                <th>Customer/Supplier Name</th>
                <th>Document No.</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
                <tr>
                </tr>
            <tr>
                <td colspan="11" style="text-align: left;">Total records: </td>
            </tr>
        </tbody>
    </table>
</div>
