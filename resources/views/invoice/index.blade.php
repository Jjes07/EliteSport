<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>{{ $title }}</title>
  <style>
    body { font-family: Arial, sans-serif; font-size: 14px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
    .total { font-weight: bold; font-size: 16px; }
  </style>
</head>
<body>
  <h1>Factura #{{ $order->getId() }}</h1>
  <p><strong>Cliente:</strong> {{ $user->getName() }}</p>
  <p><strong>Email:</strong> {{ $user->getEmail() }}</p>
  <p><strong>Fecha:</strong> {{ $order->getDate() }}</p>
  <p><strong>Estado:</strong> {{ $order->getStatus() }}</p>
  <table>
    <tr>
      <th>Producto</th>
      <th>Cantidad</th>
      <th>Precio</th>
      <th>Subtotal</th>
    </tr>
    @foreach($items as $item)
    <tr>
      <td>{{ $item->getProduct()->getName() }}</td>
      <td>{{ $item->getQuantity() }}</td>
      <td>{{ $item->getPriceFormatted() }}</td>
      <td>{{ $item->getSubtotalFormatted() }}</td>
    </tr>
    @endforeach
    <tr>
      <td colspan="3" class="total">Total</td>
      <td class="total">{{ $order->getTotalFormatted() }}</td>
    </tr>
  </table>
</body>
</html>