<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 13px;
        /* 👈 from 200px to something tighter */
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    td,
    th {
        border: 1px solid #d33;
        padding: 6px;
        vertical-align: top;
    }

    .no-border {
        border: none;
    }

    .header {
        text-align: right;
        font-weight: bold;
        font-size: 12px;
        color: #d33;
    }

    .section-title {
        background-color: #fdd;
        font-weight: bold;
        color: #d33;
    }

    .center {
        text-align: center;
    }

    .red {
        color: #d33;
    }

    .reseller {
        font-size: 15px;
        color: #d33;
        font-weight: bold;
    }

    .tuv {
        text-align: center;
        font-size: 12px;
        color: #d33;
    }

    .col-1 {
        width: 8.33%;
    }

    .col-2 {
        width: 20%;
    }

    /* was 16.66% */

    .col-3 {
        width: 25%;
    }

    .col-4 {
        width: 40%;
    }

    /* was 33.33% */
    .col-6 {
        width: 50%;
    }

    .col-12 {
        width: 100%;
    }

    .half {
        width: 50%;
        vertical-align: top;
    }

    .nested-table {
        width: 100%;
        border: none;
    }

    .nested-table td {
        border: none;
        padding: 4px 8px;
    }

    
</style>

<!-- Top Info -->
<table>
    <tr>
        <td class="no-border col-3">
            <img src="images/inmed_logo.png" alt=" " width="150"><br><br>
            <strong class="reseller">... we help the resellers</strong>
        </td>
        <td class="no-border col-4"><br>
            5 Calle Industria<br>
            Bagumbayan, Quezon City 1110, Philippines<br>
            Tel. +63 2 85711888<br>
            www.inmed.com.ph
        </td>
        <td class="no-border tuv col-2">
            <img src="images/tuv.png" alt="tuv" width="70"><br>
            <span>ISO 9001</span><br>
            2015 SERIES<br>
            CERTIFIED
        </td>
        <td class="header col-3 center">
            <strong>TELE ORDER</strong><br>
            <hr>
            <span class="red">T.O. No.: {{ $transaction->teleorder_date . $transaction->teleorder_no }}</span>
        </td>
    </tr>
</table>

<!-- Sold To / Delivery Info -->

<table width="100%" cellspacing="0" cellpadding="5">
    <tr>
        <td><strong>SOLD TO:</strong><br>{{ $customer->customer->customer }}</td>
        <td><strong>CUSTOMER CODE:</strong><br>{{ $customer->code }}</td>
        <td><strong>P.O. NUMBER:</strong><br>{{ $transaction->po_no }}</td>
        <td><strong>ORDER DATE:</strong><br>{{ $transaction->order_date }}</td>
        <td><strong>DELIVERY DATE:</strong><br>{{ $transaction->delivery_date }}<br></td>
        <td><strong>PAYMENT TERMS:</strong><br>
            {{-- ☐ CASH ☐ PDC ☐ CHARGE --}}
            {{ $transaction->paymentTerms }}
        </td>
        <td><strong>DELIVERED BY:</strong>
            {{-- ☐ AIR ☐ SEA ☐ TRUCK ☐ OTHERS: _______ --}}
            {{ $transaction->deliveredBy }}
        </td>
    </tr>
    <tr>
        <td colspan="4" class="half"><strong>DELIVER TO:</strong><br>{{ $transaction->deliveredTo }}</td>
        <td colspan="3" class="half"><strong>SPECIAL INSTRUCTION:</strong><br>{{ $transaction->specialInstruction }}</td>
    </tr>
</table>


<!-- Item Table -->
<table>
    <tr class="section-title center">
        <th>ITEM CODE</th>
        <th>QUANTITY</th>
        <th>UNIT</th>
        <th colspan="2">PRODUCT DESCRIPTION</th>
        <th>UNIT PRICE</th>
        <th>NET AMOUNT</th>
    </tr>
    <!-- Sample rows, you can duplicate as needed -->
        @foreach ($transaction->transaction_details as $item)
            <tr>
                <td>{{ $item->product->code }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->product->uom }}</td>
                <td colspan="2">{{ $item->product->description }}</td>
                <td>{{ $item->unit_price }}</td>
                <td>{{ $item->net_amount }}</td>
            </tr>  
        @endforeach
    <tr>
        <td colspan="7"><strong>TOTAL AMOUNT: </strong> {{ $totalNetAmount }}</td>
    </tr>
</table>

<!-- Footer Section -->
<table>
    <tr class="section-title center">
        <td colspan="3">FOR ENCODER USE</td>
        <td colspan="4">ORDER PLACED BY</td>
    </tr>
    <tr>
        <td><strong>PRICING VERIFIED BY:</strong><br><br></td>
        <td><strong>ENCODER:</strong><br>{{ $user }}</td>
        <td><strong>DATE:</strong><br>{{ date("Y-m-d") }}
        <strong>TIME:</strong><br>{{ date("h:ia") }}</td>
        <td>☐ TELEPHONE<br>☐ FAX<br>☐ E-MAIL</td>
        <td><strong>ORDERED BY:</strong><br><br></td>
        <td><strong>POSITION:</strong><br><br></td>
        <td><strong>SIGNATURE:</strong><br><br></td>
    </tr>
    <tr>
        <td><strong>APPROVAL:</strong><br><br></td>
        <td><strong>ORDER NO.:</strong><br><br></td>
        <td><strong>INVOICE NO.:</strong><br><br></td>
        <td colspan="4"><strong>REASONS FOR REJECTION:</strong><br>
            ☐ OVER CREDIT LIMIT ☐ HOLD ACCOUNT ☐ CANCELLED<br>
            CREDIT LIMIT: ________ C.L. BALANCE: ________<br>
            ORDER TAKEN BY: ___________
        </td>
    </tr>
</table>
