import type { Metadata } from "next";
import "./globals.css";

export const metadata: Metadata = {
  title: "Sayago AI Hub",
  description: "Hub privado de IAs de respaldo para Sergio.",
};

export default function RootLayout({
  children,
}: Readonly<{ children: React.ReactNode }>) {
  return (
    <html lang="es">
      <body>{children}</body>
    </html>
  );
}
