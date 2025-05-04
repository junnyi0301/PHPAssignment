<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html" encoding="UTF-8" indent="yes" />

    <xsl:template match="/cart">
        <xsl:for-each
            select="item">
            <div class="flex flex-col w-full m-auto justify-center">
                <div class="flex flex-row my-4 justify-center">
                    <img class="w-36 h-36 rounded-lg">
                        <xsl:attribute name="src">
                            <xsl:value-of select="image" />
                        </xsl:attribute>
                    </img>
                    <div class="flex flex-col w-1/2 justify-center">
                        <div>
                            <h3 class="font-semibold text-xl text-gray-800 px-2 text-left">
                                <xsl:value-of select="name" /> (<xsl:value-of select="option" />) </h3>
                            <div class="flex flex-row items-center px-2 justify-between">
                                <h2 class="font-semibold text-xl text-gray-400 text-left">
                                    <xsl:value-of select="price" />
                                </h2>
                                <h2 class="font-semibold text-xl text-gray-400 text-left"> x<xsl:value-of
                                        select="quantity" />
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="border-t-1 border-gray-300 mx-8"></hr>
            </div>
        </xsl:for-each>
    </xsl:template>
</xsl:stylesheet>