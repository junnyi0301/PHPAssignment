<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/">
        <div class="xml-summary">
            <h3 class="text-lg font-semibold mb-2">XML Order Summary</h3>
            <div class="space-y-1">
                <p><span class="font-medium">Area:</span> <xsl:value-of select="delivery_order/area"/></p>
                <p><span class="font-medium">Street:</span> <xsl:value-of select="delivery_order/street"/></p>
                <p><span class="font-medium">House:</span> <xsl:value-of select="delivery_order/house"/></p>
                <p><span class="font-medium">Receive in:</span> 
                    <xsl:value-of select="delivery_order/timestamp"/></p>
            </div>
        </div>
    </xsl:template>
</xsl:stylesheet>