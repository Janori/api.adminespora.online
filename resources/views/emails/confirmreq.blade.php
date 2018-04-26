<div style="width:500px;text-align:center;">
  <h2>Respuesta a ticket #{{ $data->id }}</h2>
</div>

<div style="width:500px;">
  <table style="width:100%;">
    <tr>
      <td style="text-align:right;width:250px;">Cotización de solicitud:</td>
      <td><b>${{$data->price}}</b></td>
    </tr>
    <tr>
      <td style="text-align:right;width:250px;">Fecha estimada de finalización:</td>
      <td><b>{{$data->estimated_date}}</b></td>
    </tr>
  </table>
  <h2 style="text-align:center;">Detalle de solicitud:</h2>
  <p style="margin-left: 10%; width:80%;">{{ $data->data }}</p>

  <a href="{{'http://localhost:8080/tickets/response?id=4&accepted=true&token='.$data->request_hash}}">
    Aceptar
  </a>
  <a href="{{'http://localhost:8080/tickets/response?id=4&accepted=false&token='.$data->request_hash}}">
    Rechazar
  </a>


</div>
