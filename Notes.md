
## Beschreibung der Hauptkomponenten

### `/Core`
- **Document.php**  
  Die Hauptklasse, die ein PDF-Dokument repräsentiert. Enthält grundlegende Funktionen für das Hinzufügen von Seiten und Elementen.

- **Page.php**  
  Klasse, die eine einzelne PDF-Seite repräsentiert. Bietet Methoden zur Platzierung von Elementen.

- **Element.php**  
  Abstrakte Basisklasse für alle PDF-Elemente wie Text, Bilder und Linien.

### `/Render`
- **PdfRenderer.php**  
  Render-Engine, die die PDF-Syntax generiert und die Elemente im Dokument darstellt.

- **StreamWriter.php**  
  Low-Level-Komponente zum Schreiben von Daten in eine PDF-Datei.

### `/Elements`
- **Text.php**  
  Klasse für Text-Elemente. Unterstützt Schriftarten, Größen und Farben.

- **Image.php**  
  Klasse für Bild-Elemente. Unterstützt verschiedene Bildformate und Positionierung.

- **Line.php**  
  Klasse für Linien-Elemente. Unterstützt verschiedene Linienstärken und Farben.

### `/Layout`
- **LayoutManager.php**  
  Verwaltet das Layout und die Positionierung der Elemente auf einer Seite.

### `/Utils`
- **Color.php**  
  Helferklasse für Farbdarstellungen (RGB, CMYK etc.).

- **FontManager.php**  
  Klasse für das Management von Schriftarten. Unterstützt das Laden und Verwenden verschiedener Schriftarten.

---

# Anforderungen für PDF/UA

| Feature                      | Status in deinem PDF | Benötigte Anpassung                    |
|------------------------------|----------------------|----------------------------------------|
| **Tag-Struktur**             | ❌                  | Strukturbaum (`StructTreeRoot`) fehlt  |
| **Sprache**                  | ✅                  | Korrekt definiert (`/Lang`)            |
| **Alternativtexte für Bilder** | ❌                  | `/Alt`-Attribute für Bilder hinzufügen |
| **Rollen (Tags)**            | ❌                  | Rollen wie `/H1`, `/P` definieren      |
| **Metadata**                 | ❌                  | XMP-Metadaten hinzufügen               |
| **Unicode-Unterstützung**    | ❌                  | `ToUnicode`-Maps für Fonts hinzufügen  |
| **Barrierefreiheit für Links**| ❌                  | Interaktive Tags für Links hinzufügen  |

# Kategorien von Tags

## 1. Text-Tags
Diese Tags werden verwendet, um Textelemente wie Überschriften, Absätze und andere semantische Strukturen zu definieren.

| Tag      | Bedeutung               | Anwendung                                                    |
|----------|-------------------------|--------------------------------------------------------------|
| /Document| Das gesamte Dokument    | Wurzelelement, oft im /StructTreeRoot.                       |
| /H1      | Überschrift 1. Ebene    | Für Hauptüberschriften.                                      |
| /H2      | Überschrift 2. Ebene    | Für Unterüberschriften.                                      |
| /H3      | Überschrift 3. Ebene    | Für tiefer gegliederte Überschriften.                        |
| /P       | Absatz                  | Für normalen Fließtext.                                      |
| /L       | Liste                   | Für geordnete und ungeordnete Listen.                        |
| /LI      | Listeneintrag           | Ein Element innerhalb einer Liste.                           |
| /LBody   | Listeninhalt            | Der Hauptinhalt einer Liste.                                 |
| /Span    | Inline-Textbereich      | Für Stiländerungen (z. B. fett, kursiv) innerhalb eines Absatzes. |
| /Quote   | Zitat                   | Für zitierte Inhalte.                                        |
| /Note    | Fußnote                 | Für Notizen oder Anmerkungen.                                |

## 2. Struktur-Tags
Diese Tags beschreiben die Struktur eines Dokuments auf hoher Ebene.

| Tag      | Bedeutung               | Anwendung                                |
|----------|-------------------------|------------------------------------------|
| /Part    | Abschnitt               | Für größere Teile eines Dokuments.       |
| /Sect    | Sektion                 | Für thematische Abschnitte eines Dokuments. |
| /Art     | Artikel                 | Für inhaltlich abgeschlossene Abschnitte.|
| /Div     | Division (Container)    | Generischer Container für Inhalte.       |

## 3. Tabellen-Tags
Diese Tags strukturieren Tabelleninhalte.

| Tag      | Bedeutung               | Anwendung                                    |
|----------|-------------------------|----------------------------------------------|
| /Table   | Tabelle                 | Für Tabellen als Ganzes.                     |
| /TR      | Tabellenreihe           | Für eine einzelne Zeile in der Tabelle.      |
| /TH      | Tabellenkopf            | Für Kopfzellen (z. B. Spaltenüberschriften). |
| /TD      | Tabellenzelle           | Für Datenzellen.                             |
| /TBody   | Tabellenkörper          | Für den Hauptteil der Tabelle.               |

## 4. Grafische Tags
Diese Tags definieren nicht-textuelle Inhalte wie Bilder und Formen.

| Tag      | Bedeutung               | Anwendung                                    |
|----------|-------------------------|----------------------------------------------|
| /Figure  | Bild oder Grafik        | Für Bilder, Diagramme oder andere Grafiken.  |
| /Caption | Bildunterschrift        | Für die Beschreibung einer Grafik.           |
| /Formula | Mathematische Formel    | Für mathematische Inhalte.                   |

## 5. Interaktive Tags
Diese Tags werden für interaktive Elemente in PDFs verwendet.

| Tag      | Bedeutung               | Anwendung                                    |
|----------|-------------------------|----------------------------------------------|
| /Link    | Hyperlink               | Für klickbare Links.                         |
| /Annot   | Annotation              | Für Kommentare oder andere Anmerkungen.      |
