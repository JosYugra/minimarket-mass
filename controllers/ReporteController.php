<?php
declare(strict_types=1);

require_once __DIR__ . '/../lib/fpdf.php';
require_once __DIR__ . '/../models/ProductoRepository.php';

class ReporteController
{
    // FPDF usa Latin-1: convertimos los textos con tildes/ñ
    private function latin(string $t): string
    {
        return mb_convert_encoding($t, 'ISO-8859-1', 'UTF-8');
    }

    public function catalogoPdf(): void
    {
        $repo      = new ProductoRepository();
        $productos = $repo->obtenerTodos();

        $pdf = new FPDF();
        $pdf->AddPage();

        // ---- Encabezado ----
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, $this->latin('Minimarket Mass - Catalogo'), 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6, $this->latin('Mass Cayma  -  ' . date('d/m/Y')), 0, 1, 'C');
        $pdf->Ln(4);

        // ---- Cabecera de la tabla ----
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(0, 102, 179);   // azul SENATI
        $pdf->SetTextColor(255);
        $pdf->Cell(45, 8, 'Codigo',     1, 0, 'L', true);
        $pdf->Cell(75, 8, 'Producto',   1, 0, 'L', true);
        $pdf->Cell(35, 8, 'Precio S/',  1, 0, 'R', true);
        $pdf->Cell(30, 8, 'Stock',      1, 1, 'R', true);

        // ---- Filas ----
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetTextColor(0);
        foreach ($productos as $p) {
            $pdf->Cell(45, 7, $p->getCodigo(), 1, 0);
            $pdf->Cell(75, 7, $this->latin($p->getNombre()), 1, 0);
            $pdf->Cell(35, 7, number_format($p->getPrecio(), 2), 1, 0, 'R');
            $pdf->Cell(30, 7, (string)$p->getStock(), 1, 1, 'R');
        }

        // ---- Salida al navegador ----
        $pdf->Output('I', 'catalogo_mass.pdf');
    }
}