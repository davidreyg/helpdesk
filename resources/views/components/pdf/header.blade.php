<!DOCTYPE html>
<meta charset="utf-8">
<style>
    .pageHeader {
        -webkit-print-color-adjust: exact;
        font-family: system-ui;
        font-size: 6pt;
        width: 100%;
        /* display: flex; */
        /* justify-content: space-between; */
        /* align-items: center; */
        margin: 0 30px 0 30px;
        /* position: relative; */
        /* padding: 10px; */
        /* background-color: red; */

        /* Ajusta el color de fondo si es necesario */
    }

    .logo {
        height: 50px;
        /* Ajusta el tamaño del logo según sea necesario */
    }

    .header-item {
        display: flex;
        align-items: center;
    }
</style>
<header class="pageHeader">
    <table style="width: 100%">
        <tbody>
            <tr>
                <td style="width: 20%">
                    <div class="header-item">
                        <img src="{{ $logoBase64 }}" alt="Logo" class="logo">
                    </div>
                </td>
                <td style="width: 60%; text-align: center;">
                    <img src="{{ $certificado }}" alt="Certificado" class="logo">
                </td>
                <td style="text-align: right; width: 20%;">
                    <span style="font-size: 15px"> Master Electronics Perú S.A.C</span>
                </td>
            </tr>
        </tbody>
    </table>
</header>
