<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html" encoding="UTF-8" indent="yes" />

    <!-- Template for the root element -->
    <xsl:template match="/cart">
        <xsl:if test="count(item) = 0">
            <h2 class="font-semibold text-xl text-gray-400 p-4 text-center">Cart Empty</h2>
        </xsl:if>
        <xsl:for-each
            select="item">
            <div class="flex flex-row my-4">
                <img class="w-28 h-28 rounded-lg mr-4">
                    <xsl:attribute name="src">
                        <xsl:value-of select="image" />
                    </xsl:attribute>
                </img>
                <div class="flex flex-col w-full justify-between">
                    <div>
                        <h3 class="font-semibold text-l text-gray-800 px-2 text-left">
                            <xsl:value-of select="name" /> (<xsl:value-of select="option" />)</h3>
                        <div class="flex flex-row items-center px-2 justify-between">
                            <h2 class="font-semibold text-xl text-gray-400 text-left">
                                <xsl:value-of select="price" />
                            </h2>
                            <h2 class="font-semibold text-xl text-gray-400 text-left"> x<xsl:value-of
                                    select="quantity" />
                            </h2>
                        </div>
                    </div>
                    <button
                        class="bg-indigo-400 hover:bg-indigo-500 transition duration-300 ease-in-out text-white text-s font-bold rounded">
                        <xsl:attribute name="onclick">
                            <xsl:text>removeItem(</xsl:text>
  <xsl:value-of select="id" />
  <xsl:text>, '</xsl:text>
  <xsl:value-of
                                select="option" />
  <xsl:text>')</xsl:text>
                        </xsl:attribute>
        Remove </button>
                </div>
            </div>
        </xsl:for-each>
    </xsl:template>
</xsl:stylesheet>