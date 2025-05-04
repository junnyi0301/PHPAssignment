<?xml version="1.0" encoding="UTF-8"?>

<!--
    Document   : foods.xsl
    Created on : May 4, 2025, 3:32 PM
    Author     : Admin
    Description:
        Purpose of transformation follows.
-->

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <!-- TODO customize transformation rules 
         syntax recommendation http://www.w3.org/TR/xslt 
    -->
    <xsl:template match="/">
        <html>
            <head>
                <title>Menu Items</title>
            </head>
            <body>
                <h1>Food Menu</h1>
                <p>
                    <a href="search.php">
                        <button>Search</button>
                    </a>
                </p>

                <table border="1">
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Category</th>
                    </tr>
                    <xsl:for-each select="foods/food">
                        <tr>
                            <td>
                                <xsl:value-of select="name"/>
                            </td>
                            <td>$<xsl:value-of select="price"/></td>
                            <td>
                                <xsl:value-of select="description"/>
                            </td>
                            <td>
                                <xsl:value-of select="category"/>
                            </td>
                        </tr>
                    </xsl:for-each>
                </table>
            </body>
        </html>
    </xsl:template>

</xsl:stylesheet>
